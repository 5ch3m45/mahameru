<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klasifikasi extends CI_Controller { 
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('klasifikasi_model');
    }

	public function index() {
        $page = $this->input->get('page');
        $search = $this->input->get('search');
        $sort = $this->input->get('sort');

        // validasi page start
        $page = preg_replace('/[^0-9]/i', '', $page);
        $page = (int)$page;
        if(!$page) {
            $page = 1;
        }
        // validasi page end

        // validasi page start
        $search = preg_replace('/[^a-zA-Z\d\s:]/i', '', $search);
        // validasi page end

        // validasi page start
        $sort = in_array($sort, ['kode', 'nama', 'arsip-terbanyak', 'arsip-tersedikit']) ? $sort : '';
        // validasi page end
        
        if($page) {
            $offset = PERPAGE * ($page -1);
            $klasifikasis = $this->db->select('k.id, k.kode, k.nama, k.deskripsi, k.updated_at, count(a.id) as arsip_count')
                ->from('tbl_klasifikasi k');

            if($search) {
                $klasifikasis = $klasifikasis->where('kode LIKE', '%'.$search.'%')
                    ->or_where('nama LIKE', '%'.$search.'%');
            }

            $klasifikasis = $klasifikasis->limit(PERPAGE, $offset)
                ->join('(SELECT * FROM tbl_arsip WHERE is_deleted = 0) a', 'a.klasifikasi_id = k.id', 'left')
                ->group_by('k.id');

            if($sort == 'nama') {
                $klasifikasis = $klasifikasis->order_by('k.nama', 'asc');
            } else if($sort == 'arsip-terbanyak') {
                $klasifikasis = $klasifikasis->order_by('arsip_count', 'desc');
            } else if($sort == 'arsip-tersedikit') {
                $klasifikasis = $klasifikasis->order_by('arsip_count', 'asc');
            } else {
                $klasifikasis = $klasifikasis->order_by('kode', 'asc');
            }

            $klasifikasis = $klasifikasis->where('k.is_deleted', 0)
                ->get()
                ->result_array();

            // var_dump($this->db->last_query()); die();
            
            $records = $this->db->select('count(id) as record')
                ->from('tbl_klasifikasi')
                ->where('is_deleted', 0)
                ->get()
                ->row_array();
            $total_page = ceil($records['record'] / PERPAGE);

            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $klasifikasis,
                    'current_page' => (int)$page,
                    'total_page' => (int)$total_page,
                ], JSON_PRETTY_PRINT));
        } else {
            $klasifikasis = $this->klasifikasi_model->getAll();
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $klasifikasis
                ], JSON_PRETTY_PRINT));
        }
        
	}

    public function store() {
        if(!$this->input->post()) {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                ]));
        }

        $input = $this->input->post(NULL, TRUE);

        // validasi kode
        $this->form_validation->set_rules('kode', 'Kode', 'numeric|required', [
            'required' => 'Kode tidak boleh kosong',
            'numeric' => 'Kode tidak valid',
        ]);

        // validasi nama
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required' => 'Nama tidak boleh kosong'
        ]);

        // cek kode sudah ada apa belum
        $kode = $this->klasifikasi_model->getOneByKode((int)$input['kode']);
        // jika ada kode
        $kodeError = '';
        if($kode) {
            $kodeError = 'Kode sudah terdaftar';
        }

        // jalankan validasi
        if($this->form_validation->run() == false || @$kodeError) {
            return $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'success' => false,
                        'validation' => [
                            'kode' => form_error('kode') ? form_error('kode') : @$kodeError,
                            'nama' => form_error('nama')
                        ],
                        'csrf' => $this->security->get_csrf_hash()
                    ]));
        }

        // inisiasi data yang akan disimpan ke database
        $data = [
            'kode' => (int)$input['kode'],
            'nama' => trim($input['nama']),
            'deskripsi' => @$input['deskripsi'],
            'created_at' => date('c'),
            'updated_at' => date('c')
        ];

        // simpan data ke database dan dapatkan ID
        $klasifikasiID = $this->klasifikasi_model->store($data);

        // jika tidak tersimpan
        if(!$klasifikasiID) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // dapatkan klasifikasi berdasarkan ID
        $klasifikasi = $this->klasifikasi_model->getOne($klasifikasiID);
        
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $klasifikasi,
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function top5() {
        $klasifikasis = $this->klasifikasi_model->getTop5();

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $klasifikasis,
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function update($id) {
        $klasifikasi = $this->klasifikasi_model->getOneByID($id);

        if(!$klasifikasi) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $klasifikasis,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $input = $this->input->post(NULL, TRUE);
        $data = [
            'updated_at' => date('c')
        ];
        if($input['kode']) {
            $data['kode'] = $input['kode'];
        }
        if($input['nama']) {
            $data['nama'] = $input['nama'];
        }
        if($input['deskripsi']) {
            $data['deskripsi'] = $input['deskripsi'];
        }

        $update = $this->klasifikasi_model->update($id, $data);

        if(!$update) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
    }

    public function arsip($klasifikasiID) {
        $page = $this->input->get('p', true);
        $search = $this->input->get('q', true);
        $sort = $this->input->get('s', true);

        // validasi page start
        $page = preg_replace('/[^0-9]/i', '', $page);
        $page = (int)$page;
        if(!$page) {
            $page = 1;
        }
        // validasi page end

        // validasi search start
        $search = preg_replace('/[^a-zA-Z\d\s:]/i', '', $search);
        // validasi search end

        // validasi sort start
        $sort = in_array($sort, ['terbaru', 'terlama']) ? $sort : '';
        // validasi sort end

        // set offset
        $offset = PERPAGE * ($page -1);
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal, admin_id, level, is_published')
            ->from('tbl_arsip')
            ->where('is_deleted', 0)
            ->where('klasifikasi_id', $klasifikasiID);
        
        // limitasi admin biasa
        if(in_array('arsip_publik', $this->session->userdata('user_groups'))){
            $query = $query->where('level', 2);
        }

        if($search) {
            $query = $query->where('informasi LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->or_where('tanggal LIKE', '%'.$search.'%');
        }

        if($sort) {
            if($sort == 'terlama') {
                $query = $query->order_by('nomor', 'asc');
            } else {
                $query = $query->order_by('nomor', 'desc');
            }
        } else {
            $query = $query->order_by('nomor', 'desc');
        }

        // generate arsips
        $arsips = $query->limit(PERPAGE, $offset)
            ->get()
            ->result_array();
        foreach ($arsips as $key => $value) {
            // add lampiran detail
            $arsips[$key]['lampirans'] = $this->db->select('type, url')
                ->from('tbl_lampiran')
                ->where('arsip_id', $value['id'])
                ->where('is_deleted', 0)
                ->get()
                ->result_array();
            // format tahun
            $arsips[$key]['tanggal_formatted'] = date('d M Y', strtotime($value['tanggal']));
            // add admin detail
            $arsips[$key]['admin_detail'] = $this->db->select('name')
                ->from('users')
                ->where('id', $value['admin_id'])
                ->limit(1)
                ->get()
                ->row_array();
        }


        // count total page
        $records = $query->count_all_results();
        $total_page = ceil($records/PERPAGE);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $arsips,
                'current_page' => (int)$page,
                'total_page' => (int)$total_page,
            ], JSON_PRETTY_PRINT));
    }
}

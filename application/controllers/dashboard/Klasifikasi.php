<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klasifikasi extends CI_Controller {
    protected $myroles;

	function __construct() {
		parent::__construct();
		$this->load->library('myrole');
		$this->load->library('session');
        
		$this->lang->load('auth');

		$this->load->model([
			'arsip_model',
			'klasifikasi_model',
			'lampiran_model'
		]);

		// limitasi otoritas
		$this->myrole->is('klasifikasi', true);
        $this->myroles = $this->myrole->asArray();
	}

	public function index() {
		$this->load->view('dashboard/klasifikasi/index');
	}

	public function detail($id) {
		$id = preg_replace('/[^0-9]/', '', $id);
		
		$klasifikasi = $this->db->select('*')
			->from('tbl_klasifikasi')
			->where('id', $id)
			->get()
			->row_array();
		
		if(!$klasifikasi) {
			return show_404();
		}
		
		$this->load->view('dashboard/klasifikasi/detail', compact('klasifikasi'));
	}

	// ===== API START =====
	public function API_index() {
        $page = $this->input->get('page');
        $search = $this->input->get('search');
        $sort = $this->input->get('sort');

        // validasi page start
        $page = preg_replace('/[^0-9]/i', '', $page);
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
        
		$offset = PERPAGE * ($page -1);
		$query = $this->db->select('k.id, k.kode, k.nama, k.deskripsi, k.updated_at')
			->from('tbl_klasifikasi k');

		if($search) {
			$query = $query->where('kode LIKE', '%'.$search.'%')
				->or_where('nama LIKE', '%'.$search.'%');
		}

		$query = $query->limit(PERPAGE, $offset)
			->group_by('k.id');

		if($sort == 'nama') {
			$query = $query->order_by('k.nama', 'asc');
		} else if($sort == 'arsip-terbanyak') {
			$query = $query->order_by('arsip_count', 'desc');
		} else if($sort == 'arsip-tersedikit') {
			$query = $query->order_by('arsip_count', 'asc');
		} else {
			$query = $query->order_by('kode', 'asc');
		}

		$klasifikasis = $query->where('k.is_deleted', 0)
			->get()
			->result_array();

		foreach ($klasifikasis as $key => $value) {
			$klasifikasis[$key]['arsip_count'] = $this->db->select('id')
				->from('tbl_arsip')
				->where('klasifikasi_id', $value['id'])
				->where('status <>', 3)
				->count_all_results();
		}

		return $this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode([
				'success' => true,
				'data' => $klasifikasis,
			], JSON_PRETTY_PRINT));
	}

    public function API_detail($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        if(!$id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Klasifikas tidak ditemukan.',
                ], JSON_PRETTY_PRINT));
        }

        $klasifikasi = $this->db->select('*')
            ->from('tbl_klasifikasi')
            ->where('id', $id)
            ->get()
            ->row_array();

        if(!$klasifikasi) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Klasifikas tidak ditemukan.',
                ], JSON_PRETTY_PRINT));
        }

        $klasifikasi['last_updated'] = date('d M Y H:i:s', strtotime($klasifikasi['updated_at']));

        $klasifikasi['arsip_count'] = $this->db->select('id')
            ->from('tbl_arsip')
            ->where('klasifikasi_id', $klasifikasi['id'])
            ->where('status <>', 3)
            ->count_all_results();

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => false,
                'data' => $klasifikasi,
            ], JSON_PRETTY_PRINT));
    }

    public function API_store() {
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

    public function API_top5() {

        $klasifikasis = $this->db->select('tbl_klasifikasi.id, tbl_klasifikasi.kode, tbl_klasifikasi.nama, count(tbl_arsip.id) as arsip_count')
            ->from('tbl_klasifikasi')
            ->join('tbl_arsip', 'tbl_arsip.klasifikasi_id = tbl_klasifikasi.id', 'left')
            ->where('tbl_arsip.status', 2)
            ->group_by('tbl_klasifikasi.id')
            ->order_by('arsip_count', 'desc')
            ->limit(5)
            ->get()
            ->result_array();

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $klasifikasis,
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_update($id) {
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

    public function API_arsip($klasifikasiID) {
        $page = $this->input->get('page', true);
        $search = $this->input->get('search', true);
        $status = $this->input->get('status', true);
        $level = $this->input->get('level', true);
        $sort = $this->input->get('sort', true);

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
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal, admin_id, level, status')
            ->from('tbl_arsip')
            ->where('status <>', 3)
            ->where('klasifikasi_id', $klasifikasiID);

        if($search) {
            $query = $query->where('informasi LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->or_where('tanggal LIKE', '%'.$search.'%');
        }

        if(in_array($status, ['draft', 'publikasi', 'dihapus'])) {
            if($status == 'draft') {
                $query = $query->where('status', 1);
            }
            if($status == 'publikasi') {
                $query = $query->where('status', 2);
            }
            if($status == 'dihapus') {
                $query = $query->where('status', 3);
            }
        }

        // limitasi admin biasa
        if(in_array('arsip_publik', $this->myroles)){
            $query = $query->where('level', 2);
        } else {
            if(in_array($level, ['rahasia', 'publik'])) {
                if($level == 'rahasia') {
                    $query = $query->where('level', 1);
                }
                if($level == 'publik') {
                    $query = $query->where('level', 2);
                }
            }
        }

        if($sort) {
            if($sort == 'terlama') {
                $query = $query->order_by('tanggal', 'asc');
            } else {
                $query = $query->order_by('tanggal', 'desc');
            }
        } else {
            $query = $query->order_by('tanggal', 'desc');
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('string');
        $this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->model('arsip_model');
        $this->load->model('klasifikasi_model');
        $this->load->model('lampiran_model');
    }

	public function store() {
        $response = [
            'success' => true
        ];
        
		return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT));
	}

    public function update($id) {
        if(!$this->input->post()) {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                ]));
        }
        
        $input = $this->input->post(NULL, TRUE);

        // jika tidak ada id arsip yang mau diupdate
        if(!$id) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        
        // jika parameter id tidak integer
        if(!is_int((int)$id)) {
            return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => false,
                'csrf' => $this->security->get_csrf_hash()
            ]));
        }

        // cari arsip berdasarkan id
        $arsip = $this->arsip_model->getFirst($id);

        // jika arsip ditemukan
        if($arsip) {
            // validasi kolom nomor
            $this->form_validation->set_rules('nomor', 'Nomor', 'numeric', [
                'numeric' => 'Nomor tidak valid'
            ]);
            // validasi kolom tahun
            $this->form_validation->set_rules('tahun', 'Tahun', 'numeric', [
                'numeric' => 'Tahun tidak valid'
            ]);

            // validasi kolom nomor
            if((int)$input['nomor'] != $arsip['nomor']) {
                $nomor = $this->arsip_model->getFirstByNomor((int)$input['nomor']);
                if($nomor) {
                    $nomorError = 'Nomor telah terdaftar';
                }
            }
            
            // validasi kolom klasifikasi
            $klasifikasiID = '';
            // jika ada input klasifikasi
            if(@$input['klasifikasi']) {
                // jika input klasifikasi adalah integer
                if(is_int((int)$input['klasifikasi'])) {
                    // cari klasifikasi
                    $klasifikasi = $this->klasifikasi_model->getFirst((int)$input['klasifikasi']);
                    // jika klasifikasi ditemukan
                    if($klasifikasi) {
                        // tulis id klasifikasi
                        $klasifikasiID = $klasifikasi['id'];
                    }
                // jika input klasifikasi bukan integer
                } else {
                    // inisiasi pesan error
                    $klasifikasiError = 'Klasifikasi tidak ditemukan';
                }
            }

            // jika validasi gagal
            if($this->form_validation->run() == FALSE || @$klasifikasiError || @$penciptaError) {
                // return output json
                return $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'success' => false,
                        'validation' => [
                            'nomor' => form_error('nomor'),
                            'tahun' => form_error('tahun'),
                            'klasifikasi' => @$klasifikasiError,
                            'pencipta' => @$penciptaError
                        ],
                        'csrf' => $this->security->get_csrf_hash()
                    ]));
            }

            // kemas data update dalam array
            $data = [
                'nomor' => @$input['nomor'],
                'tahun' => @$input['tahun'],
                'pencipta' => @$input['pencipta'],
                'informasi' => @$input['informasi'],
                'klasifikasi_id' => @(int)$input['klasifikasi'],
                'admin_id' => 1,
                'updated_at' => date('c')
            ];
            
            // jika update berhasil
            $this->arsip_model->update((int)$id, $data);

            // dapatkan data terbaru
            $arsip = $this->arsip_model->getFirst($id);
            
            if($arsip['admin_id']) {
                $admin = $this->admin_model->getFirst($arsip['admin_id']);
                $arsip['admin'] = $admin;
            }

            // cek apakah arsip ada klasifikasi
            if($arsip['klasifikasi_id']) {
                // jika ada, cari klasifikasi
                $klasifikasi = $this->klasifikasi_model->getFirst($arsip['klasifikasi_id']);
                // tambahkan ke array arsip
                $arsip['klasifikasi'] = $klasifikasi;
            }

            // return json 200
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => 'Arsip berhasil disimpan',
                    'data' => $arsip,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        
        // return arsip tidak ditemukan 404
        return $this->output
            ->set_status_header(404)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Arsip tidak ditemukan',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function storeLampiran($id) {
        $input = $this->input->post(NULL, TRUE);

        if(!$id) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // jika parameter id tidak integer
        if(!is_int((int)$id)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cari arsip berdasarkan id
        $arsip = $this->arsip_model->getFirst($id);

        if($arsip) {
            $random = random_string('alnum', 6);
            $config['upload_path']          = APPPATH.'/../assets/uploads';
            $config['allowed_types']        = 'gif|jpg|png|pdf|mp4';
            $config['file_name']            = $random.'-'.$_FILES['file']['name'];
    
            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('file')) {
                return $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'success' => false,
                        'validation' => $this->upload->display_errors(),
                        'csrf' => $this->security->get_csrf_hash()
                    ]));
            } else {
                $uploadData = $this->upload->data();

                $data = [
                    'url' => '/assets/uploads/'.$uploadData['file_name'],
                    'type' => $uploadData['file_type'],
                    'arsip_id' => $arsip['id'],
                    'admin_id' => 1,
                    'created_at' => date('c'),
                    'updated_at' => date('c')
                ];

                $lampiranID = $this->lampiran_model->store($data);

                $lampiran = $this->lampiran_model->getOne($lampiranID);

                return $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'success' => true,
                        'data' => $lampiran,
                        'upload' => $this->upload->data(),
                        'csrf' => $this->security->get_csrf_hash()
                    ]));
            }
        }

        // return arsip tidak ditemukan 404
        return $this->output
            ->set_status_header(404)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Arsip tidak ditemukan',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }
}

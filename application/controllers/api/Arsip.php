<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper([
            'string'
        ]);
        $this->load->library('form_validation');
        $this->load->model([
            'admin_model',
            'arsip_model',
            'lampiran_model',
            'klasifikasi_model'
        ]);
    }

    public function index() {
        $page = $this->input->get('page', TRUE);

		if(!$page) {
			$page = 1;
		}

		if(!is_int((int)$page)){
			$page = 1;
		}

		$arsips = $this->arsip_model->getPaginated($page);

		foreach ($arsips as $key => $arsip) {
			// tambah key lampiran
			$arsipLampirans = [];
			$lampirans = $this->lampiran_model->getTop2LampiransByArsip($arsip['id']);
			$lampiransCount = $this->lampiran_model->countLampiranByArsip($arsip['id']);
			if($lampiransCount) {
				foreach ($lampirans as $lampiran) {
					array_push($arsipLampirans, [
						'type' => $lampiran['type'],
						'url' => $lampiran['url']
					]);
				}
			}
			if($lampiransCount > 2) {
				array_push($arsipLampirans, [
					'type' => 'number',
					'url' => $lampiransCount - 2
				]);
			}
			$arsips[$key]['lampirans'] = $arsipLampirans;

			// tambah key klasifikasi
            $arsips[$key]['klasifikasi'] = [];
			if($arsip['klasifikasi_id']) {
				$arsips[$key]['klasifikasi'] = $this->klasifikasi_model->getOne($arsip['klasifikasi_id']);
			}

            // tambah key admin
            $arsips[$key]['admin'] = [];
            if($arsip['admin_id']) {
                $arsips[$key]['admin'] = $this->admin_model->getOneByID($arsip['admin_id']);
            }
		}
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $arsips,
            ]));
    }

    public function show($id) {
        if(!$id || !is_int((int)$id)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Bad request'
                ], JSON_PRETTY_PRINT));
        }

        $arsip = $this->arsip_model->getOneByID((int)$id);

        if(!$arsip) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan'
                ], JSON_PRETTY_PRINT));
        }

        // tambah key klasifikasi
        $arsip['klasifikasi'] = [];
        if($arsip['klasifikasi_id']) {
			$arsip['klasifikasi'] = $this->klasifikasi_model->getOne($arsip['klasifikasi_id']);
		}

        // tambah key lampiran
        $arsip['lampirans'] = $this->lampiran_model->getAllByArsipID($arsip['id']);

        // format last updated
        $arsip['last_updated'] = date('d M Y H:i:s', strtotime($arsip['updated_at']));

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $arsip,
            ], JSON_PRETTY_PRINT));
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
                    $klasifikasi = $this->klasifikasi_model->getOne((int)$input['klasifikasi']);
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
                $klasifikasi = $this->klasifikasi_model->getOne($arsip['klasifikasi_id']);
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
        if(!$arsip) {
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

        $random = random_string('alnum', 6);
        $config['upload_path']          = APPPATH.'/../assets/uploads';
        $config['allowed_types']        = 'gif|jpg|png|pdf|mp4|jpeg';
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

    public function destroyLampiran($arsipID, $lampiranID) {
        // hanya post request
        $this->onlyPOSTRequest();
        // cari arsip
        $arsip = $this->arsip_model->getOne($arsipID);
        // cek apakah arsip ditemukan
        if(!$arsip['id']) {
            // jika tidak ditemukan, return not found
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cari lampiran
        $lampiran = $this->lampiran_model->getOneWithWhere([
            'id' => $lampiranID,
            'arsip_id' => $arsip['id']
        ]);
        // cek apakah lampiran ditemukan
        if(!$lampiran) {
            // jika lampiran tidak ditemukan
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Lampiran tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // soft delete file lampiran lampiran
        $delete = $this->lampiran_model->softDelete($lampiran['id']);
        if(!$delete) {
            // jika tidak berhasi dihapus, return 500 server error
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Lampiran berhasil dihapus',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function publish($arsipID) {
        // hanya post request
        $this->onlyPOSTRequest();
        // cari arsip
        $arsip = $this->arsip_model->getOne($arsipID);
        // cek apakah arsip ditemukan
        if(!$arsip['id']) {
            // jika tidak ditemukan, return not found
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $publish = $this->arsip_model->publish($arsip['id']);
        if(!$publish) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil dipublikasi',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function draft($arsipID) {
        // hanya post request
        $this->onlyPOSTRequest();
        // cari arsip
        $arsip = $this->arsip_model->getOne($arsipID);
        // cek apakah arsip ditemukan
        if(!$arsip['id']) {
            // jika tidak ditemukan, return not found
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $publish = $this->arsip_model->draft($arsip['id']);
        if(!$publish) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil didraft',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function destroy($arsipID) {
        // hanya post request
        $this->onlyPOSTRequest();
        // cari arsip
        $arsip = $this->arsip_model->getOne($arsipID);
        // cek apakah arsip ditemukan
        if(!$arsip['id']) {
            // jika tidak ditemukan, return not found
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $deleted = $this->arsip_model->delete($arsip['id']);
        if(!$deleted) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil dihapus',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function last5() {
        $arsips = $this->arsip_model->getLast5();
        foreach($arsips as $key => $arsip) {
            // tambahkan klasifikasi
            if($arsip['klasifikasi_id']) {
                $arsips[$key]['klasifikasi'] = $this->klasifikasi_model->getOneByID($arsip['klasifikasi_id']);
            }
            // tambahkan pengolah
            if($arsip['admin_id']) {
                $arsips[$key]['admin'] = $this->admin_model->getOneByID($arsip['admin_id']);
            }
            // tambahkan lampiran
            $arsips[$key]['lampirans'] = [];
			$lampirans = $this->lampiran_model->getTop2LampiransByArsip($arsip['id']);
			$lampiransCount = $this->lampiran_model->countLampiranByArsip($arsip['id']);
			if($lampiransCount) {
				foreach ($lampirans as $lampiran) {
					array_push($arsips[$key]['lampirans'], [
						'type' => $lampiran['type'],
						'url' => $lampiran['url']
					]);
				}
			}
			if($lampiransCount > 2) {
				array_push($arsips[$key]['lampirans'], [
					'type' => 'number',
					'url' => $lampiransCount - 2
				]);
			}
        }
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $arsips,
                'csrf' => $this->security->get_csrf_hash()
            ])); 
    }

    public function chartData() {
        $end = date('Y-m-d');
        $begin = date('Y-m-d', strtotime("-2 week", strtotime($end)));

        $data = $this->arsip_model->getLast30DaysPerDay($begin);
        if(!$data) {
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => [],
                    'csrf' => $this->security->get_csrf_hash()
                ])); 
        }

        $begin = new DateTime($begin);
        $end = new DateTime(date('Y-m-d', strtotime("+1 day", strtotime($end))));
        $interval = DateInterval::createFromDateString('1 day');
        $periode = new DatePeriod($begin, $interval, $end);

        $result = [];
        foreach ($periode as $key => $date) {
            $currentDate = $date->format('Y-m-d');
            $search = array_search($currentDate, array_column($data, 'date'));
            if(is_int($search)) {
                $data[$search]['formatted_date'] = $date->format('d/m');
                array_push($result, $data[$search]);
            } else {
                array_push($result, [
                    'date' => $currentDate,
                    'formatted_date' => $date->format('d/m'),
                    'count' => 0
                ]);
            }
        }

        return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode([
            'success' => true,
            'data' => $result,
            'csrf' => $this->security->get_csrf_hash()
        ])); 
    }
}

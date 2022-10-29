<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {

    protected $is_admin = FALSE;

    public function __construct() {
        parent::__construct();
        $this->lang->load('auth');
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

        $this->is_admin = false;
        if($this->session->is_logged_in) {
            $this->is_admin = in_array('admin', $this->session->user_groups);
        }
    }

    

    public function admin_index() {
        $page = $this->input->get('page', TRUE);

		if(!$page) {
			$page = 1;
		}

		if(!is_int((int)$page)){
			$page = 1;
		}

        if($this->session->is_logged_in) { 
            $arsips = $this->arsip_model->getPaginated($page, $this->is_admin);
        } else {
            $arsips = $this->arsip_model->getPaginatedPublic($page, $this->is_admin);
        }
        
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
                if($this->session->is_logged_in) { 
                    $arsips[$key]['klasifikasi'] = $this->klasifikasi_model->getOne($arsip['klasifikasi_id']);
                } else {
                    $arsips[$key]['klasifikasi'] = $this->klasifikasi_model->getOneByIDPublic($arsip['klasifikasi_id']);
                }
			}

            if($this->session->is_logged_in) {
                // tambah key admin jika data ditampilkan ke admin
                $arsips[$key]['admin'] = [];
                if($arsip['admin_id']) {
                    $arsips[$key]['admin'] = $this->admin_model->getOneByID($arsip['admin_id']);
                }
            }
            
            // format key tanggal
            if($arsip['tanggal']) {
                if($this->session->is_logged_in) {
                    $arsips[$key]['tanggal_formatted'] = date('d M Y', strtotime($arsip['tanggal']));
                } else {
                    $arsips[$key]['tahun'] = date('Y', strtotime($arsip['tanggal']));
                }
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

    

	public function store() {
        $response = [
            'success' => true
        ];
        
		return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT));
	}

    

    

    

    

    

    

    

    

    
}

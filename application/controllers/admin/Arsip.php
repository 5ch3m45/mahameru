<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Arsip extends CI_Controller {

	protected $is_admin;

	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model([
			'arsip_model',
			'lampiran_model',
			'klasifikasi_model'
		]);

		if(!$this->session->is_logged_in) {
			redirect(base_url('login'));
		}

		$this->is_admin = in_array('admin', $this->session->user_groups);
	}
	
	public function index() {
		$this->load->view('admin_panel/arsip/index');
	}

	public function create() {
		$last_arsip = $this->arsip_model->getLastNumberArsip();

		$arsip_id = $this->arsip_model->create([
			'nomor' => $last_arsip['nomor'] + 1,
			'admin_id' => $this->session->user_id,
			'created_at' => date('c'),
			'updated_at' => date('c')
		]);
		redirect(base_url('admin/arsip/detail/'.$arsip_id));
	}

	public function detail($id) {
		$this->load->model('arsip_model');

		$arsip = $this->arsip_model->getOneByID($id, $this->is_admin);
		
		if(!$arsip) {
			echo 'Not found';
			die();
		}
		$klasifikasis = $this->klasifikasi_model->getAll();
		$lampirans = $this->lampiran_model->getBatchByArsip($arsip['id']);

		$this->load->view('admin_panel/arsip/detail', compact('arsip', 'klasifikasis', 'lampirans'));
	}

	public function do_upload() {
		$this->load->helper('string');

        $config['upload_path']   = APPPATH.'/../assets/uploads';
        $config['allowed_types'] = '*';
		$config['file_name']     = random_string('numeric', 6).'-'.$_FILES['file']['name'];
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            return $this->output->set_output(
				json_encode([
					'success' => false,
					'data' => $error,
				]));
        } else {
            $data = array('upload_data' => $this->upload->data());

            return $this->output->set_output(
				json_encode([
					'success' => true,
					'data' => $this->upload->data('file_name'),
				]));
        }
    }
}

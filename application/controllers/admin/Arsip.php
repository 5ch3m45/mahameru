<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Arsip extends CI_Controller {

	protected $is_admin;

	function __construct() {
		parent::__construct();
		$this->load->library(['ion_auth']);
        $this->lang->load('auth');
		if (!$this->ion_auth->logged_in()) {
			redirect('signin');
		}
		$this->load->model([
			'arsip_model',
			'lampiran_model',
			'klasifikasi_model'
		]);
		$this->is_admin = $this->ion_auth->is_admin();
	}
	public function index() {
		$this->load->view('admin/arsip_index');
	}

	public function create() {
		$this->load->model('arsip_model');
		$last_arsip = $this->arsip_model->getLastNumberArsip();

		$admin = $this->ion_auth->user()->row();

		$arsip_id = $this->arsip_model->create([
			'nomor' => $last_arsip['nomor'] + 1,
			'admin_id' => $admin->id,
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

		$this->load->view('admin/arsip_detail', compact('arsip', 'klasifikasis', 'lampirans'));
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library(['ion_auth']);
        $this->lang->load('auth');
		if (!$this->ion_auth->logged_in()) {
			redirect('signin');
		}
		if (!$this->ion_auth->is_admin()) {
			redirect(base_url('admin/dashboard'));
		}
		$this->load->model('admin_model');
	}

	public function index() {
		$this->load->view('admin/admin_index');
	}

	public function detail($id) {
		if(!is_int((int)$id)) {
			return show_404();
		}

		$admin = $this->admin_model->getOneByID((int)$id);
		
		if(!$admin) {
			return show_404();
		}
		
		$this->load->view('admin/admin_detail');
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
        $this->lang->load('auth');
		$this->load->library('session');
		$this->load->model('admin_model');

		if(!$this->session->is_logged_in) {
			redirect(base_url('login'));
		}
	}

	public function index() {
		$this->load->view('admin_panel/admin/index');
	}

	public function detail($id) {
		if(!is_int((int)$id)) {
			return show_404();
		}

		$admin = $this->admin_model->getOneByID((int)$id);
		
		if(!$admin) {
			return show_404();
		}
		
		$this->load->view('admin_panel/admin/detail');
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();

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

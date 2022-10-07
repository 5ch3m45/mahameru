<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aduan extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model([
			'aduan_model'
		]);
	}

	public function index() {
		$this->load->view('admin_panel/aduan/index');
	}

	public function detail($id) {
		if(!is_int((int)$id)) {
			return show_404();
		}

		$aduan = $this->aduan_model->getOneByID((int)$id);
		
		if(!$aduan) {
			return show_404();
		}
		
		$this->load->view('admin_panel/aduan/detail');
	}
}

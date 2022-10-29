<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {
	public function index() {
		$this->load->view('artikel');
	}

	public function show($id) {
		$this->load->view('artikel_detail');
	}
}

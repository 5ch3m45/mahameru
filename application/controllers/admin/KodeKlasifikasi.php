<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KodeKlasifikasi extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->model('arsip_model');
		$this->load->model('klasifikasi_model');
	}

	public function index() {
		$page = $this->input->get('page', TRUE);

		if(!$page) {
			$page = 1;
		}

		if(!is_int((int)$page)) {
			$page = 1;
		}
		
		$klasifikasis = $this->klasifikasi_model->getBatch($page);

		foreach ($klasifikasis as $key => $klasifikasi) {
			$arsipCounter = $this->arsip_model->countArsipByKlasifikasi($klasifikasi['id']);
			$klasifikasis[$key]['arsip_count'] = $arsipCounter;
		}

		$this->load->view('admin/kode_klasifikasi_index', compact('klasifikasis'));
	}

	public function detail($id) {

		if(!is_int((int)$id)) {
			return show_404();
		}

		$klasifikasi = $this->klasifikasi_model->getOne((int)$id);
		
		if(!$klasifikasi) {
			return show_404();
		}

		$arsipCount = $this->arsip_model->countArsipByKlasifikasi($klasifikasi['id']);

		$page = $this->input->get('page', TRUE);
		if(!$page) {
			$page = 1;
		}

		if(!is_int((int)$page)) {
			return show_404();
		}

		$arsips = $this->arsip_model->getBatchByKlasifikasi($klasifikasi['id'], $page);

		$this->load->view('admin/kode_klasifikasi_detail', compact('klasifikasi', 'arsipCount', 'arsips'));
	}
}

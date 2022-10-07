<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Klasifikasi extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('session');
        
		$this->lang->load('auth');

		$this->load->model([
			'arsip_model',
			'klasifikasi_model',
			'lampiran_model'
		]);

		if (!$this->session->is_logged_in) {
			redirect(base_url('login'));
		}
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

		$this->load->view('admin_panel/klasifikasi/index', compact('klasifikasis'));
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
		foreach ($arsips as $key => $arsip) {
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
		}
		
		$this->load->view('admin_panel/klasifikasi/detail', compact('klasifikasi', 'arsipCount', 'arsips'));
	}
}

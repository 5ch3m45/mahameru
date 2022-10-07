<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model([
			'arsip_model',
			'klasifikasi_model',
			'lampiran_model'
		]);
	}

	function _lampiranParser($lampiran) {
		if(in_array($lampiran['type'], ['image/jpeg', 'image/png'])) {
			return '<img 
				data-id="'.$lampiran['id'].'" 
				data-url="'.$lampiran['url'].'" 
				class="lampiran lampiran-'.$lampiran['id'].' my-masonry-grid-item p-1" 
				style="max-width: 100%;" 
				src="'.$lampiran['url'].'">';
		} else if(in_array($lampiran['type'], ['video/mp4'])) {
			return '<img 
				data-id="'.$lampiran['id'].'" 
				data-url="'.$lampiran['url'].'" 
				class="lampiran lampiran-'.$lampiran['id'].' my-masonry-grid-item p-1" 
				style="max-width: 100%;" 
				src="'.base_url('assets/images/mp4.png').'">';
		} else if(in_array($lampiran['type'], ['application/pdf'])) {
			return '<img 
				data-id="'.$lampiran['id'].'" 
				data-url="'.$lampiran['url'].'" 
				class="lampiran lampiran-'.$lampiran['id'].' my-masonry-grid-item p-1" 
				style="max-width: 100%;" 
				src="'.base_url('assets/images/pdf.png').'">';
		}
	}
	function _lampiranParserUrl($lampiran) {
		if(in_array($lampiran['type'], ['image/jpeg', 'image/png'])) {
			return $lampiran['url'];
		} else if(in_array($lampiran['type'], ['video/mp4'])) {
			return base_url('assets/images/mp4.png');
		} else if(in_array($lampiran['type'], ['application/pdf'])) {
			return base_url('assets/images/pdf.png');
		}
	}

	public function index() {
		$this->load->view('public/arsip/index');
	}

	public function show($id) {
		// format id jadi integer
		$id = intval($id);
		// jika bukan integer, 404
		if(!$id) {
			show_404();
		}
		
		// cek apa arsip ada
		$arsip = $this->db->select('id, klasifikasi_id, tanggal, nomor, informasi, pencipta')
			->from('tbl_arsip')
			->where('id', $id)
			->limit(1)
			->get()
			->row_array();

		// jika tidak ada, 404
		if(!$arsip) {
			show_404();
		}

		// cek apa ada klasifikasi
		if($arsip['klasifikasi_id']) {
			// set data klasifikasi
			$kode_klasifikasi = $this->klasifikasi_model->getOneByID($arsip['klasifikasi_id']);
			if($kode_klasifikasi) {
				$arsip['kode_klasifikasi'] = $kode_klasifikasi;
			}
		}

		// cek apa ada tanggal
		if($arsip['tanggal']) {
			// set data tahun arsip
			$arsip['tahun'] = date('Y', strtotime($arsip['tanggal']));
		}

		// dapatkan lampiran
		$lampirans = $this->lampiran_model->getAllByArsipID($arsip['id']);
		$arsip['lampirans'] = [];
		foreach ($lampirans as $lampiran) {
			$lampiran['url_parsed'] = $this->_lampiranParserUrl($lampiran);
			array_push($arsip['lampirans'], $lampiran);
		}

		$this->data['arsip'] = $arsip;
		// var_dump($this->data); die();
		$this->load->view('public/arsip/detail', $this->data);
	}
}

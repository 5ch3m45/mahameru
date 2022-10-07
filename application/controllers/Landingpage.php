<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;

class Landingpage extends CI_Controller {
	
	public function index() {
		$captcha = new CaptchaBuilder();
		
		$_SESSION['phrase'] = $captcha->getPhrase();
		$data['captcha'] = $captcha->build()->inline();

		$arsip_hari_ini = $this->db->select('id, informasi, klasifikasi_id, tanggal')
			->from('tbl_arsip')
			->where('tanggal', date('Y-m-d'))
			->where('level', 2)
			->where('is_published', 1)
			->where('is_deleted', 0)
			->get()
			->result_array();

		foreach ($arsip_hari_ini as $key => $value) {
			// first lampiran
			$arsip_hari_ini[$key]['lampiran'] = $this->db->select('type, url')
				->from('tbl_lampiran')
				->where('arsip_id', $value['id'])
				->where('is_deleted', 0)
				->where('type LIKE', '%image%')
				->limit(1)
				->get()
				->row_array();
			// get klasifikasi
			$arsip_hari_ini[$key]['klasifikasi'] = $this->db->select('id, kode, nama')
				->from('tbl_klasifikasi')
				->where('id', $value['klasifikasi_id'])
				->get()
				->row_array();
			// format tanggal
			$arsip_hari_ini[$key]['tanggal_formatted'] = date('d/m/Y', strtotime($value['tanggal']));
		}

		$data['arsip_hari_ini'] = $arsip_hari_ini;

		$this->load->view('landingpage', $data);
	}
	
	public function encrypt() {
		$this->load->library('encryption');
		var_dump(bin2hex($this->encryption->create_key(16)));
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aduan extends CI_Controller {
	function __construct() {
		parent::__construct();
        $this->load->helper('formatter_helper');
		$this->load->library('form_validation');
		$this->load->library('myrole');

		// limitasi otoritas
		$this->myrole->is('aduan', true);

		$this->load->model([
			'aduan_model'
		]);
	}

	public function index() {
		$this->load->view('dashboard/aduan/index');
	}

	public function detail($id) {
		$id = preg_replace('/[^0-9]/', '', $id);

		$aduan = $this->db->select('*')
			->from('tbl_aduan')
			->where('id', $id)
			->get()
			->row_array();
		
		if(!$aduan) {
			return show_404();
		}
		
		$this->load->view('dashboard/aduan/detail');
	}

	// ===== API START =====
	function API_index() {
        $page = $this->input->get('page', true);
		$search = $this->input->get('search', true);
		$status = $this->input->get('status', true);
		$sort = $this->input->get('sort', true);
		
        // validasi page start
        $page = preg_replace('/[^0-9]/i', '', $page);
        if(!$page) {
            $page = 1;
        }
        // validasi page end

        $aduans = $this->aduan_model->getAduanDashboard($page, $search, $status, $sort);
        $count_aduans = $this->aduan_model->countAduanDashboard($search, $status);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' 		=> true,
                'data' 			=> $aduans,
				'current_page' 	=> (int)$page,
				'total_page'	=> (int)ceil($count_aduans/PERPAGE),
                'csrf' 			=> $this->security->get_csrf_hash(),
            ], JSON_PRETTY_PRINT));
    }

	function API_detail($aduanID) {
        $aduan = $this->db->select('*')
			->from('tbl_aduan')
			->where('id', $aduanID)
			->where('is_deleted', 0)
			->get()
			->row_array();

        if(!$aduan) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Aduan tidak ditemukan'
                ]));
        }

        $aduanStatus = $this->db->select('*')
			->from('tbl_aduan_timeline')
			->where('aduan_id', $aduan['id'])
			->where('is_deleted', 0)
			->get()
			->result_array();
        foreach ($aduanStatus as $key => $status) {
            $aduanStatus[$key]['created_at_formatted'] = date('d M Y', strtotime($status['created_at']));
        }
        $aduan['timeline'] = $aduanStatus;
        
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $aduan
            ]));
    }

    function API_update($aduanID) {
		$aduanID = preg_replace('/[^0-9]/', '', $aduanID);
        $aduan = $this->db->select('*')
			->from('tbl_aduan')
			->where('id', $aduanID)
			->where('is_deleted', 0)
			->get()
			->row_array();
        if(!$aduan) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Aduan tidak ditemukan'
                ]));
        }

        $input = $this->input->post(null, true);
		
		//write ke aduan timeline
		$this->db->insert('tbl_aduan_timeline', [
			'aduan_id' => $aduan['id'],
			'status' => $input['status']
		]);

		// update status aduan
		$this->db->where('id', $aduan['id'])
			->update('tbl_aduan', [
				'status' => $input['status'],
				'updated_at' => date('c')
			]);
        
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
				'csrf' => $this->security->get_csrf_hash()
            ]));
    }
}

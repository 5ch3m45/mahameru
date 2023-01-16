<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('session');
        $this->load->library('myrole');
        $this->load->model('arsip_model');

        if(!$this->session->is_logged_in) {
            redirect(base_url('login'));
        }
    }
    
	public function index() {
        $total_viewers = $this->arsip_model->totalViewers();
		$this->load->view('dashboard/index', [
            'title' => 'Dashboard',
            'slug' => 'dashboard',
            'total_viewers' => $total_viewers['total']
        ]);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('session');
        $this->load->library('myrole');

        if(!$this->session->is_logged_in) {
            redirect(base_url('login'));
        }
    }
    
	public function index() {
        $data = [
            'title' => 'Dashboard',
            'slug' => 'dashboard'
        ];
		$this->load->view('admin_panel/dashboard', $data);
	}
}

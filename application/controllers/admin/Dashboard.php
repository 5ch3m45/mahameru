<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('session');

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

    public function toIndex() {
        redirect(base_url('admin/dashboard'));
    }
}

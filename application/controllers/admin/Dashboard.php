<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['ion_auth']);
        $this->lang->load('auth');
        if (!$this->ion_auth->logged_in()) {
			redirect('signin');
		}
    }
	public function index() {
        $data = [
            'title' => 'Dashboard',
            'slug' => 'dashboard'
        ];
		$this->load->view('admin/dashboard', $data);
	}

    public function toIndex() {
        redirect(base_url('admin/dashboard'));
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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

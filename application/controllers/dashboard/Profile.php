<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	protected $myroles;
	
	function __construct() {
		parent::__construct();
        $this->lang->load('auth');

		$this->load->helper('string');
		$this->load->library('myrole');
		$this->load->library('session');

		if(!$this->session->is_logged_in) {
			redirect(base_url('login'));
		}

		$this->myroles = $this->myrole->asArray();
	}

    function index() {
        $this->load->view('/dashboard/profile/index');
    }

    function API_index() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->select('name, email')
            ->from('users')
            ->where('id', $user_id)
            ->get()
            ->row_array();
        
        return $this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode([
				'success' => true,
				'data' => $user,
			], JSON_PRETTY_PRINT));
    }

    function API_update_name() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->select('name, email')
            ->from('users')
            ->where('id', $user_id)
            ->get()
            ->row_array();

        if(!$user) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Bad request',
                    'csrf' => $this->security->get_csrf_hash()
                ], JSON_PRETTY_PRINT));
        }
        
        $this->db->where('id', $user_id)
            ->update('users', [
                'name' => $this->input->post('name', true)
            ]);
        
        $user['name'] = $this->input->post('name', true);

        return $this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode([
				'success' => true,
				'data' => $user,
			], JSON_PRETTY_PRINT));
    }

    function API_update_password() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->select('name, email')
            ->from('users')
            ->where('id', $user_id)
            ->get()
            ->row_array();

        if(!$user) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Bad request',
                    'csrf' => $this->security->get_csrf_hash(),
                ], JSON_PRETTY_PRINT));
        }
        
        $input = $this->input->post(null, false);
        if(strlen($input['new_password']) < 6) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'new_password' => 'Kata sandi tidak boleh kurang dari 6 karakter.'
                    ],
                    'csrf' => $this->security->get_csrf_hash(),
                ], JSON_PRETTY_PRINT));
        }

        if($input['new_password'] !== $input['new_password_confirm']) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'csrf' => $this->security->get_csrf_hash(),
                    'validation' => [
                        'new_password_confirm' => 'Konfirmasi kata sandi tidak sama.'
                    ],
                    'csrf' => $this->security->get_csrf_hash()
                ], JSON_PRETTY_PRINT));
        }

        $this->db->where('id', $user_id)
            ->update('users', [
                'password' => password_hash($input['new_password'], PASSWORD_ARGON2I)
            ]);

        return $this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode([
				'success' => true,
                'csrf' => $this->security->get_csrf_hash(),
				'data' => $user,
			], JSON_PRETTY_PRINT));
    }

    
}
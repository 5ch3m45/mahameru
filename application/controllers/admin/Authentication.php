<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;

class Authentication extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('admin_model');
		$this->load->library('session');
	}

	public function login() {
		if($this->session->userdata('is_logged_in')) {
			redirect(base_url('admin/dashboard'));
		}

		$captcha = new CaptchaBuilder();
		
		$_SESSION['phrase'] = $captcha->getPhrase();
		$data['captcha'] = $captcha->build()->inline();

		$this->load->view('admin_panel/auth/login', $data);
	}

	function forgotPassword() {
		$this->load->view('admin_panel/auth/forgot_password');
	}

	function resetPassword($token) {
		$exploded_token = explode('.', $token);
		if(count($exploded_token) == 2) {
			// cek apakah user valid
			$selector = $exploded_token[0];
			$user = $this->admin_model->getOneByForgotPasswordSelector($selector);
			if($user) {
				// cek apakah token valid
				$user_token = $exploded_token[1];
				$token_is_verified = password_verify($user_token, $user['forgotten_password_code']);
				if($token_is_verified) {
					// cek apakah token masih berlaku
					if(time() - $user['forgotten_password_time'] < 30*60) { // 30 menit
						$this->data['success'] = true;
						$this->data['message'] = 'Token valid.';
					} else {
						$this->data['success'] = false;
						$this->data['message'] = 'Token sudah tidak berlaku.';
					}
				} else {
					$this->data['success'] = false;
					$this->data['message'] = 'Token tidak valid.';
				}
			} else {
				$this->data['success'] = false;
				$this->data['message'] = 'User tidak ditemukan.';
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Token tidak valid.';
		}

		$this->data['token'] = $token;
		$this->load->view('admin_panel/auth/reset_password', $this->data);
	}
}

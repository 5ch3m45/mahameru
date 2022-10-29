<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Authentication extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->lang->load('auth');
        $this->load->helper('string');
		$this->load->library('session');
		$this->load->model('admin_model');
		$this->load->model('group_model');
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

	// ===== API START =====
	function API_signin() {
        // validasi login
        if($this->form_validation->run('login') == FALSE) {
            // generate captcha baru
            unset($_SESSION['phrase']);
            $captcha = new CaptchaBuilder();
            $_SESSION['phrase'] = $captcha->getPhrase();
            $captcha_baru = $captcha->build()->inline();
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'email' => form_error('email'),
                        'password' => form_error('password'),
                        'captcha' => form_error('phrase')
                    ],
                    'captcha' => $captcha_baru,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // validasi captcha
        $captcha_is_valid = false;
        if (isset($_SESSION['phrase']) && PhraseBuilder::comparePhrases($_SESSION['phrase'], $this->input->post('phrase', true))) {
            $captcha_is_valid = true;
        }
        if(!$captcha_is_valid) {
            // generate captcha baru
            unset($_SESSION['phrase']);
            $captcha = new CaptchaBuilder();
            $_SESSION['phrase'] = $captcha->getPhrase();
            $captcha_baru = $captcha->build()->inline();
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'captcha' => 'Verifikasi tidak valid.'
                    ],
                    'captcha' => $captcha_baru,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cek user
        $user = $this->admin_model->getOneByEmail($this->input->post('email', true));
        // rate limit
        // jika sudah mencoba lebih dari 5 kali, maka hanya bisa mencoba login setiap 5 menit sekali
        $limitedSession = $this->session->userdata('limited_until') > date('c');
        if(isset($user['login_attempts']) && ($user['login_attempts'] >= 5 && $limitedSession)) {
            // update waktu limit
            $this->session->set_userdata(['limited_until' => date('c', strtotime('+5 min'))]);
            
            // generate captcha baru
            unset($_SESSION['phrase']);
            $captcha = new CaptchaBuilder();
            $_SESSION['phrase'] = $captcha->getPhrase();
            $captcha_baru = $captcha->build()->inline();

            // return error
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'email' => 'Silahkan coba beberapa saat lagi.'
                    ],
                    'captcha' => $captcha_baru,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cek apakah password valid
        if(!password_verify($this->input->post('password', false), $user['password'])) {
            // update jumlah percobaan login
            $this->db->update('users', [
                'login_attempts' => $user['login_attempts'] + 1
            ], [
                'id' => $user['id']
            ]);

            // update waktu limit
            $this->session->set_userdata(['limited_until' => date('c', strtotime('+5 min'))]);

            // generate captcha baru
            unset($_SESSION['phrase']);
            $captcha = new CaptchaBuilder();
            $_SESSION['phrase'] = $captcha->getPhrase();
            $captcha_baru = $captcha->build()->inline();

            // jika tidak valid
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'password' => 'Password salah.'
                    ],
                    'captcha' => $captcha_baru,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // jika berhasil, reset rate limit & update last login
        $this->db->update('users', [
            'login_attempts' => 0,
            'last_login' => date('c')
        ], [
            'id' => $user['id']
        ]);

        $groups = $this->db->select('ug.id, ug.group_id, g.name')
            ->from('users_groups ug')
            ->join('groups g', 'g.id = ug.group_id', 'left')
            ->where('ug.user_id', $user['id'])
            ->get()
            ->result_array();
        $user['groups'] = [];
        foreach ($groups as $key => $value) {
            array_push($user['groups'], $value['name']);
        }

        $this->session->set_userdata([
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'user_groups' => $user['groups'],
            'is_logged_in' => TRUE
        ]);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Login berhasil.',
                'csrf' => $this->security->get_csrf_hash()
            ]));
	}

    function API_logout() {
        $this->session->sess_destroy();
        return $this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode([
				'success' => true
			]));
    }

    function API_forgotPassword() {
        // validate email
        if($this->form_validation->run('forgot_password') == FALSE) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'email' => form_error('email'),
                    ],
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // validasi user
        $email = $this->input->post('email');
        $user = $this->admin_model->getOneByEmail($email);
        if(!$user) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Admin tidak ditemukan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $selector = random_string('alnum', 20);
        $token = random_string('alnum', 64);
        $token_hashed = password_hash($token, PASSWORD_ARGON2I);

        $update_token = $this->admin_model->setForgotPasswordCredential($user['email'], $selector, $token_hashed);

        if(!$update_token) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $this->load->config('email');
        $this->load->library('email');
        $this->email->set_newline('\r\n');
        $this->email->from('admin@mahameru.wonosobokab.go.id');
        $this->email->to($user['email']);
        $this->email->subject('Verifikasi Perubahan Password');
        $this->email->message('<p>Hi '.$user['name'].'.</p>
            <p>Anda telah meminta pembaruan password akun Mahameru.</p>
            <p>Klik link dibawah ini untuk melakukan pembaruan password:</p>
            <br>
            <a href="https://mahameru.wonosobokab.go.id/forgot-password/'.$selector.'.'.$token.'">https://mahameru.wonosobokab.go.id/forgot-password/'.$selector.'.'.$token.'</a>
            <br>
            <p>NB: Jika Anda tidak merasa meminta pembaruan password, harap abaikan email ini dan segera laporkan kepada Admin.</p>
            <br>
            <br>
            <p>Terimakasih,</p>
            <p>Admin Mahameru</p>
        ');

        $send_email = $this->email->send();

        if(!$send_email) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Tidak dapat mengirim email pembaruan password.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Email pembaruan password telah berhasil dikirim.',
                'csrf' => $this->security->get_csrf_hash()
            ]));
	}

    function API_resetPassword() {
        $token = $this->input->post('forgot_password_token');
        $exploded_token = explode('.', $token);
        // validasi format token
        if(count($exploded_token) < 2) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Token tidak valid.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        
        // validasi user
        $selector = $exploded_token[0];
        $user = $this->admin_model->getOneByForgotPasswordSelector($selector);
        if(!$user) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Token tidak valid.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        
        // validasi token
        $user_token = $exploded_token[1];
        $token_is_verified = password_verify($user_token, $user['forgotten_password_code']);
        if(!$token_is_verified) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Token tidak valid.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // validasi waktu token
        if(time() - $user['forgotten_password_time'] > 30*60) { // 30 menit
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Token sudah tidak berlaku.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // validasi password
        if($this->form_validation->run('reset_password') == FALSE) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'password' => form_error('password'),
                        'confirm_password' => form_error('confirm_password'),
                    ],
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

		// update password user
        $hashed_password = password_hash($this->input->post('password'), PASSWORD_ARGON2I);
        $update = $this->admin_model->updateAdminPassword($user['id'], $hashed_password);

        if(!$update) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // kirim email pembaruan kata sandi berhasil

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Password berhasil diperbarui.',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    function API_user() {
        if(!$this->session->is_logged_in) {
            return $this->output
                ->set_status_header(401)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Unauthorized.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $user = $this->admin_model->getOneById($this->session->user_id);
        if(!$user) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'User tidak ditemukan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $groups = $this->group_model->getByUserID($user['id']);
        $user['groups'] = [];
        foreach ($groups as $key => $value) {
            array_push($user['groups'], $value['name']);
        }
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'image' => $user['image'] ? $user['image'] : base_url('assets/images/default-user.png'),
                    'groups' => $user['groups']
                ],
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }
}

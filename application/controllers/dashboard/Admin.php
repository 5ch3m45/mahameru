<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	protected $myroles;
	
	function __construct() {
		parent::__construct();
        $this->lang->load('auth');

		$this->load->helper('string');
		$this->load->library('myrole');
		$this->load->library('session');
		$this->load->model('admin_model');

		if(!$this->session->is_logged_in) {
			redirect(base_url('login'));
		}

		$this->myroles = $this->myrole->asArray();
	}
	
	// ===== VIEW START =====
	public function index() {
		$this->load->view('dashboard/admin/index');
	}

	public function detail($userID) {
		$userID = preg_replace('/[^0-9]/i', '', $userID);
		$admin = $this->db->select('id, name, email, image, last_login')
            ->from('users')
            ->where('id', $userID)
            ->limit(1)
            ->get()
            ->row_array();
		
		if(!$admin) {
			return show_404();
		}
		
		$this->load->view('dashboard/admin/detail', compact('admin'));
	}

	// ===== API START =====
	public function API_index() {
        $page = $this->input->get('page', TRUE);

        // validasi page start
        $page = preg_replace('/[^0-9]/i', '', $page);
        $page = (int)$page;
        if(!$page) {
            $page = 1;
        }
        // validasi page end

        // set offset 
        $offset = PERPAGE * ($page -1);

        // get admin
		$admins = $this->db->select('id, name, email, image, DATE_FORMAT(last_login, "%e %b %Y %H:%i:%s") as last_login, active')
			->from('users')
			->limit(PERPAGE, $offset)
			->get()
			->result_array();
        
		foreach ($admins as $key => $value) {
			$admins[$key]['arsip_count'] = $this->db->select('id')
				->from('tbl_arsip')
				->where('admin_id', $value['id'])
				->count_all_results();
		}

        // get total_page info
        $records = $this->db->select('count(id) as record')
            ->from('users')
            ->get()
            ->row_array();
        $total_page = ceil($records['record'] / PERPAGE);

		return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $admins,
                'current_page' => (int)$page,
                'total_page' => (int)$total_page
            ]));
	}

	public function API_detail($userID) {
        $userID = preg_replace('/[^0-9]/i', '', $userID);

        if(!$userID) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'messsage' => 'ID Admin tidak valid'
                ]));
        }

        $admin = $this->db->select('id, name, email, image, last_login, active')
            ->from('users')
            ->where('id', $userID)
            ->limit(1)
            ->get()
            ->row_array();
            
        if(!$admin) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'messsage' => 'Admin tidak ditemukan'
                ]));
        }

		// jumlah arsip yang ditulis
		$admin['arsip_count'] = $this->db->select('id')
			->from('tbl_arsip')
			->where('admin_id', $admin['id'])
			->count_all_results();
		
        $admin['last_login_formatted'] = $admin['last_login'] ? date('d-m-Y H:i:s', strtotime($admin['last_login'])) : '-';

        // add roles
         $admin['roles'] = $this->db->select('ug.id, ug.group_id, g.description')
            ->from('users_groups ug')
            ->join('groups g', 'g.id = ug.group_id', 'left')
            ->where('ug.user_id', $admin['id'])
            ->get()
            ->result_array();

        return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $admin
                ]));
    }

    public function API_nonaktif($userID) {
        if($this->input->method() !== 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed.'
                ]));
        }

        $user = $this->db->select('id, active')
            ->from('users')
            ->where('id', $userID)
            ->limit(1)
            ->get()
            ->row_array();
        
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

        if(!$user['active']) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'User sudah nonaktif.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        try {
            $this->db->where('id', $user['id'])
                ->update('users', [
                    'active' => 0
                ]);
                
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        } catch (\Throwable $th) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => $th->getMessage(),
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
    }

    public function API_aktif($userID) {
        if($this->input->method() !== 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed.'
                ]));
        }

        $user = $this->db->select('id, active')
            ->from('users')
            ->where('id', $userID)
            ->limit(1)
            ->get()
            ->row_array();
        
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

        if($user['active']) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'User sudah aktif.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        try {
            $this->db->where('id', $user['id'])
                ->update('users', [
                    'active' => 1
                ]);
                
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        } catch (\Throwable $th) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => $th->getMessage(),
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
    }

    public function API_updateOtoritas($userID) {
        $input = $this->input->post(null, true);
        // validate user
        $user = $this->db->select('*')
            ->from('users')
            ->where('id', $userID)
            ->limit(1)
            ->get()
            ->row_array();

        if(!$user) {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Admin tidak ditemukan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // hapus role lama
        $this->db->delete('users_groups', [
            'user_id' => $user['id']
        ]);

        // tambahkan role baru
        $roles = json_decode($input['roles']);
        if($roles->pengelola) {
            $this->db->insert('users_groups', [
                'user_id' => $user['id'],
                'group_id' => 1
            ]);
        }
        if($roles->arsip == 'semua') {
            $this->db->insert('users_groups', [
                'user_id' => $user['id'],
                'group_id' => 2
            ]);
        }
        if($roles->arsip == 'publik') {
            $this->db->insert('users_groups', [
                'user_id' => $user['id'],
                'group_id' => 3
            ]);
        }
        if($roles->aduan) {
            $this->db->insert('users_groups', [
                'user_id' => $user['id'],
                'group_id' => 4
            ]);
        }
        if($roles->klasifikasi) {
            $this->db->insert('users_groups', [
                'user_id' => $user['id'],
                'group_id' => 5
            ]);
        }
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_create() {
        $input = $this->input->post(null, true);
        // debug only
        if($this->form_validation->run('admin_create') == FALSE) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'email' => form_error('email'),
                        'nama' => form_error('nama'),
                    ],
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // if email exist, reject
        $admin_exist = $this->admin_model->getOneByEmail($input['email']);
        if($admin_exist) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => [
                        'email' => '<small class="text-danger">Email telah terdaftar sebagai Admin</small>'
                    ],
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $password = random_string('alnum', 8);
        
        $this->load->config('email');
        $this->load->library('email');
        $this->email->set_newline('\r\n');
        $this->email->from('admin@mahameru.wonosobokab.go.id', 'Admin Mahameru');
        $this->email->to($input['email']);
        $this->email->subject('Verifikasi Email Admin Mahameru');
        $this->email->message('<p>Hi '.$input['nama'].'.</p>
            <p>Anda telah terdaftar sebagai Admin di platform Mahameru Dinas Kearsipan dan Perpustakaan Daerah Kabupaten Wonosobo.</p>
            <p>Berikut adalah informasi akun Anda:</p>
            <table>
            <tr><td><strong>Nama:</strong></td><td>'.$input['nama'].'</td></tr>
            <tr><td><strong>Email:</strong></td><td>'.$input['email'].'</td></tr>
            <tr><td><strong>Password:</strong></td><td>'.$password.'</td></tr>
            <tr><td><strong>Halaman login:</strong></td><td><a href="https://mahameru.wonosobokab.go.id/login">https://mahameru.wonosobokab.go.id/login</a></td></tr>
            </table>
            <br>
            <p>NB: Segera ganti password Anda setelah login</p>
            <br>
            <br>
            <p>Terimakasih,</p>
            <p>Admin Mahameru</p>
        ');
            
        if($this->email->send()) {
            $username = strtolower(explode('@', $input['email'])[0]);
            $additional_data = [
                'name' => $input['nama']
            ];
            
            // write ke database
            $this->db->insert('users', [
                'username' => $username,
                'name' => $input['nama'],
                'email' => $input['email'],
                'password' => password_hash($password, PASSWORD_ARGON2I),
                'active' => 1,
            ]);

            // get ID
            $user = $this->db->select('id')
                ->from('users')
                ->where('email', $input['email'])
                ->limit(1)
                ->get()
                ->row_array();

            // write role
            $roles = json_decode($input['roles']);
            if($roles->pengelola) {
                $this->db->insert('users_groups', [
                    'user_id' => $user['id'],
                    'group_id' => 1
                ]);
            }
            if($roles->arsip == 'semua') {
                $this->db->insert('users_groups', [
                    'user_id' => $user['id'],
                    'group_id' => 2
                ]);
            }
            if($roles->arsip == 'publik') {
                $this->db->insert('users_groups', [
                    'user_id' => $user['id'],
                    'group_id' => 3
                ]);
            }
            if($roles->aduan) {
                $this->db->insert('users_groups', [
                    'user_id' => $user['id'],
                    'group_id' => 4
                ]);
            }
            if($roles->klasifikasi) {
                $this->db->insert('users_groups', [
                    'user_id' => $user['id'],
                    'group_id' => 5
                ]);
            }

            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'error' => show_error($this->email->print_debugger()),
                    'csrf' => $this->security->get_csrf_hash()
                ]));
    }
}

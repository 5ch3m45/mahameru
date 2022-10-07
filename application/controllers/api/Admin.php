<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/ion_auth/controllers/Auth.php';
require_once APPPATH . 'third_party/ion_auth/libraries/Ion_auth.php';
class Admin extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model([
            'admin_model',
            'arsip_model'
        ]);
        $this->load->library([
            'form_validation', 
            'ion_auth'
        ]);
        $this->lang->load('auth');
        $this->load->helper('string');

    }

	public function index() {
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
        $admins = $this->db->select('u.id, u.name, u.email, u.image, DATE_FORMAT(u.last_login, "%e %b %Y %H:%i:%s") as last_login, count(a.id) as arsip_count')
            ->from('users u')
            ->join('(SELECT id, admin_id, is_deleted FROM tbl_arsip WHERE is_deleted = 0) a', 'a.admin_id = u.id', 'left')
            ->limit(PERPAGE, $offset)
            ->group_by('u.id')
            ->get()
            ->result_array();

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
    
    public function show($id) {
        if(!is_int((int)$id)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'messsage' => 'ID Admin tidak valid'
                ]));
        }

        $admin = $this->admin_model->getOneByID((int)$id);

        if(!$admin) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'messsage' => 'Admin tidak ditemukan'
                ]));
        }

        $admin['arsip_count'] = $this->arsip_model->countArsipByAdmin($admin['id']);
        $admin['last_login_formatted'] = $admin['last_login'] ? gmdate('d-m-Y H:i:s', $admin['last_login']) : date('d-m-Y H:i:s');

        return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $admin
                ]));
    }

    public function create() {
        $input = $this->input->post(null, true);
        // debug only
        $input['email'] = 'maulanaichwana@gmail.com';
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
        $this->email->from('admin@mahameru.wonosobokab.go.id');
        $this->email->to('maulanaichwana@gmail.com');
        $this->email->subject('Verifikasi Email Admin Mahameru');
        $this->email->message('<p>Hi '.$input['nama'].'.</p>
            <p>Anda telah terdaftar sebagai Admin di platform Mahameru Dinas Kearsipan dan Perpustakaan Daerah Kabupaten Wonosobo.</p>
            <p>Berikut adalah informasi akun Anda:</p>
            <table>
            <tr><td><strong>Nama:</strong></td><td>'.$input['nama'].'</td></tr>
            <tr><td><strong>Email:</strong></td><td>'.$input['email'].'</td></tr>
            <tr><td><strong>Password:</strong></td><td>'.$password.'</td></tr>
            <tr><td><strong>Halaman login:</strong></td><td><a href="https://mahameru.wonosobokab.go.id/signin">https://mahameru.wonosobokab.go.id/signin</a></td></tr>
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
            $group = [2]; // USER
            $this->ion_auth->register($username, $password, $input['email'], $additional_data, $group);

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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
	protected $myrole_is_arsip_public;
    protected $myroles;

	function __construct() {
		parent::__construct();

		$this->load->helper('string');
		$this->load->library('myrole');
		$this->load->library('session');
		$this->load->model('arsip_model');
		$this->load->model('lampiran_model');
		$this->load->model('klasifikasi_model');

		if(!$this->session->is_logged_in) {
			redirect(base_url('login'));
		}

		// limitasi otoritas
		$this->myrole->are(['arsip_publik', 'arsip_semua'], true);

		// get my role
		$this->myrole_is_arsip_public = $this->myrole->is('arsip_publik');
        $this->myroles = $this->myrole->asArray();
	}
	
	// ===== VIEW START =====
	public function index() {
		$this->load->view('admin_panel/arsip/index');
	}

	public function create() {
        $last_arsip = $this->db->select('id, nomor')
            ->from('tbl_arsip')
            ->where('status <>', 3)
            ->order_by('nomor', 'desc')
            ->limit(1)
            ->get()
            ->row_array();

		$arsip_id = $this->arsip_model->create([
            'level' => 2,
			'nomor' => $last_arsip['nomor'] + 1,
			'admin_id' => $this->session->user_id,
			'created_at' => date('c'),
			'updated_at' => date('c')
		]);
		redirect(base_url('dashboard/arsip/detail/'.$arsip_id));
	}

	public function detail($id) {
		$id = preg_replace('/[^0-9]/', '', $id);

        if(!$id) {
            return show_404();
        }

		$arsip = $this->db->select('id')
            ->from('tbl_arsip')
            ->where('id', $id);

        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }

        $arsip = $arsip->get()
            ->row_array();
		
		if(!$arsip) {
			return show_404();
		}

		$this->load->view('admin_panel/arsip/detail', compact('arsip'));
	}

	public function do_upload() {
		$this->load->helper('string');

        $config['upload_path']   = APPPATH.'/../assets/uploads';
        $config['allowed_types'] = '*';
		$config['file_name']     = random_string('numeric', 6).'-'.$_FILES['file']['name'];
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            return $this->output->set_output(
				json_encode([
					'success' => false,
					'data' => $error,
				]));
        } else {
            $data = array('upload_data' => $this->upload->data());

            return $this->output->set_output(
				json_encode([
					'success' => true,
					'data' => $this->upload->data('file_name'),
				]));
        }
    }

	// ===== API START =====
	public function API_index() {
        $page = $this->input->get('page', true);
        $search = $this->input->get('search', true);
        $status = $this->input->get('status', true);
        $sort = $this->input->get('sort', true);
        $user = $this->input->get('user', true);
        $level = $this->input->get('level', true);

        // validasi page start
        $page = preg_replace('/[^0-9]/i', '', $page);
        $page = (int)$page;
        if(!$page) {
            $page = 1;
        }
        // validasi page end

        // validasi search start
        $search = preg_replace('/[^a-zA-Z\d\s:]/i', '', $search);
        // validasi search end

        // set offset
        $offset = PERPAGE * ($page -1);
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal, level, status, admin_id')
            ->from('tbl_arsip');

		// search query
        if($search) {
            $query = $query->where('informasi LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->or_where('tanggal LIKE', '%'.$search.'%');
        }

		// status query
		if($status && in_array($status, ['draft', 'publikasi', 'dihapus'])) {
            if($status == 'draft') {
                $query = $query->where('status', 1);
            }
            if($status == 'publikasi') {
                $query = $query->where('status', 2);
            }
            if($status == 'dihapus') {
                $query = $query->where('status', 3);
            }
		} else {
            $query = $query->where('status <>', 3);
        }

		// pengelola arsip biasa ga bisa search arsip rahasia
        if(in_array('arsip_semua', $this->myroles)) {
            if($level && in_array($level, ['publik', 'rahasia'])) {
                if($level == 'rahasia') {
                    $query = $query->where('level', 1);
                }
                if($level == 'publik') {
                    $query = $query->where('level', 2);
                }
            }
        } else {
            $query = $query->where('level', 2);
        }

        // user query
        $user = preg_replace('/[^0-9]/i', '', $user);
        if($user) {
            $query = $query->where('admin_id', $user);
        }

        // sort query
        if(in_array($sort, ['terbaru', 'terlama', 'nomoraz', 'nomorza'])) {
            if($sort == 'terbaru') {
                $query = $query->order_by('tanggal', 'desc');
            }
            if($sort == 'terlama') {
                $query = $query->order_by('tanggal', 'asc');
            }
            if($sort == 'nomoraz') {
                $query = $query->order_by('nomor', 'asc');
            }
            if($sort == 'nomorza') {
                $query = $query->order_by('nomor', 'desc');
            }
        } else {
            $query = $query->order_by('tanggal', 'desc');
        }

        // generate arsips
        $arsips = $query->limit(PERPAGE, $offset)
            ->get()
            ->result_array();

        foreach ($arsips as $key => $value) {
            // add klasifikasi detail
            $arsips[$key]['klasifikasi'] = $this->db->select('kode, nama')
                ->from('tbl_klasifikasi')
                ->where('id', $value['klasifikasi_id'])
                ->get()
                ->row_array();
            // add lampiran detail
            $arsips[$key]['lampirans'] = $this->db->select('type, url')
                ->from('tbl_lampiran')
                ->where('arsip_id', $value['id'])
                ->where('is_deleted', 0)
                ->get()
                ->result_array();
            // format tahun
            if($value['tanggal']) {
                if($this->session->is_logged_in) {
                    $arsips[$key]['tanggal_formatted'] = date('d M Y', strtotime($value['tanggal']));
                } else {
                    $arsips[$key]['tahun'] = date('Y', strtotime($value['tanggal']));
                }
            }
            // add admin
            $arsips[$key]['admin'] = $this->db->select('name')
                ->from('users')
                ->where('id', $value['admin_id'])
                ->get()
                ->row_array();
        }

        // count total page
        $records = $query->count_all_results();
        $total_page = ceil($records/PERPAGE);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $arsips,
                'current_page' => (int)$page,
                'total_page' => (int)$total_page,
            ], JSON_PRETTY_PRINT));
    }

    public function API_detail($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        
        if(!$id) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Bad request'
                ], JSON_PRETTY_PRINT));
        }

        $arsip = $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $id);

        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }

        $arsip = $arsip->get()
            ->row_array();

        if(!$arsip) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan'
                ], JSON_PRETTY_PRINT));
        }

        // tambah key klasifikasi
        $arsip['klasifikasi'] = [];
        if($arsip['klasifikasi_id']) {
			$arsip['klasifikasi'] = $this->klasifikasi_model->getOne($arsip['klasifikasi_id']);
		}

        // tambah key lampiran
        $arsip['lampirans'] = $this->lampiran_model->getAllByArsipID($arsip['id']);

        // format tanggal
        $arsip['tanggal_formatted'] = date('d M Y', strtotime($arsip['tanggal']));
         
        // format last updated
        $arsip['last_updated'] = date('d M Y H:i:s', strtotime($arsip['updated_at']));

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $arsip,
            ], JSON_PRETTY_PRINT));
    }

    public function API_update($id) {
        if(!$this->input->post()) {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        
        $input = $this->input->post(NULL, TRUE);

        // jika tidak ada id arsip yang mau diupdate
        $id = preg_replace('/[^0-9]/', '', $id);
        if(!$id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cari arsip berdasarkan id
        $arsip = $this->db->select('id, nomor, klasifikasi_id')
            ->from('tbl_arsip')
            ->where('id', $id);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }
        $arsip = $arsip->get()
            ->row_array();

        if(!$arsip) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // init update data
        $update = [
            'level' => $input['level'],
            'updated_at' => date('c')
        ];

        // validasi
        if(isset($input['nomor']) && !empty($input['nomor']) && $input['nomor'] !== $arsip['nomor']) {
            $nomor_exist = $this->db->select('id, nomor')
                ->from('tbl_arsip')
                ->where('nomor', $input['nomor'])
                ->where('status <>', 3)
                ->get()
                ->row_array();
            if($nomor_exist) {
                return $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'success' => false,
                        'message' => 'Nomor sudah terdaftar.',
                        'csrf' => $this->security->get_csrf_hash()
                    ]));
            }

            $update['nomor'] = $input['nomor'];
        }

        if(isset($input['klasifikasi']) && !empty($input['klasifikasi']) && $input['klasifikasi'] !== $arsip['klasifikasi_id']) {
            $klasifikasi = $this->db->select('id')
                ->where('id', $input['klasifikasi'])
                ->where('is_deleted', 0)
                ->get()
                ->row_array();

            if(!$klasifikasi) {
                return $this->output
                    ->set_status_header(404)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'success' => false,
                        'message' => 'Klasifikasi tidak ditemukan.',
                        'csrf' => $this->security->get_csrf_hash()
                    ]));
            }

            $input['klasifikasi_id'] = $input['klasifikasi'];
        }
        
        if(isset($input['tanggal']) && !empty($input['tanggal'])) {
            $update['tanggal'] = $input['tanggal'];
        }

        if(isset($input['pencipta']) && !empty($input['pencipta'])) {
            $update['pencipta'] = $input['pencipta'];
        }

        if(isset($input['informasi']) && !empty($input['informasi'])) {
            $update['informasi'] = $input['informasi'];
        }

        // update
        $this->db->where('id', $arsip['id'])
            ->update('tbl_arsip', $update);

        // get data terbaru
        $arsip = $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $arsip['id'])
            ->get()
            ->row_array();
        
        $arsip['admin'] = $this->db->select('name')
            ->from('users')
            ->where('id', $arsip['admin_id'])
            ->get()
            ->row_array();

        if($arsip['klasifikasi_id']) {
            $arsip['klasifikasi'] = $this->db->select('id, kode, nama')
                ->from('tbl_klasifikasi')
                ->where('id', $arsip['klasifikasi_id'])
                ->get()
                ->row_array();
        }

        if($arsip['tanggal']) {
            $arsip['tanggal_formatted'] = date('d M Y', strtotime($arsip['tanggal']));
        }

        // return json 200
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil disimpan',
                'data' => $arsip,
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_storeLampiran($id) {
        $this->load->library('image_lib');
        $input = $this->input->post(NULL, TRUE);

        $id = preg_replace('/[^0-9]/', '', $id);

        if(!$id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cari arsip berdasarkan id
        $arsip = $this->db->select('id')
            ->from('tbl_arsip')
            ->where('id', $id);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }
        $arsip = $arsip->get()
            ->row_array();

        if(!$arsip) {
            // return arsip tidak ditemukan 404
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $random = random_string('alnum', 6);
        $config['upload_path']          = APPPATH.'/../assets/uploads';
        $config['allowed_types']        = 'gif|jpg|png|pdf|mp4|jpeg';
        $config['file_name']            = $random.'-'.$_FILES['file']['name'];

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('file')) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'validation' => $this->upload->display_errors(),
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        
        $uploadData = $this->upload->data();

        if(in_array($uploadData['file_ext'], ['.jpg', '.png', '.jpeg'])) {
            $this->resizeImage($uploadData['full_path']);
            $this->overlayWatermark($uploadData['full_path']);
            $this->TextWatermark($uploadData['full_path']);
            $this->Text2Watermark($uploadData['full_path']);
        }
        
        $data = [
            'url' => '/assets/uploads/'.$uploadData['file_name'],
            'type' => $uploadData['file_type'],
            'arsip_id' => $arsip['id'],
            'admin_id' => $this->session->userdata('user_id'),
            'created_at' => date('c'),
            'updated_at' => date('c')
        ];


        $this->db->insert('tbl_lampiran', $data);

        $lampiran = $this->db->select('*')
            ->from('tbl_lampiran')
            ->order_by('id', 'desc')
            ->limit(1)
            ->get()
            ->row_array();

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $lampiran,
                'upload' => $this->upload->data(),
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function textWatermark($source_image)
    {
        $config['source_image'] = $source_image;
        //The image path,which you would like to watermarking
        $config['wm_text'] = 'Dinas Kearsipan dan Perpustakaan Daerah';
        $config['wm_type'] = 'text';
        // $config['wm_font_path'] = './fonts/atlassol.ttf';
        $config['wm_font_size'] = 60;
        $config['wm_font_color'] = 'FF5733';
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'left';
        $config['wm_padding'] = 0;
        $config['wm_vrt_offset'] = -40;
        $config['wm_hor_offset'] = 100;

        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) {
            return $this->image_lib->display_errors();
        }
    }
    public function text2Watermark($source_image)
    {
        $config['source_image'] = $source_image;
        //The image path,which you would like to watermarking
        $config['wm_text'] = 'Kabupaten Wonosobo';
        $config['wm_type'] = 'text';
        // $config['wm_font_path'] = './fonts/atlassol.ttf';
        $config['wm_font_size'] = 60;
        $config['wm_font_color'] = 'FF5733';
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'left';
        $config['wm_padding'] = 0;
        $config['wm_vrt_offset'] = -20;
        $config['wm_hor_offset'] = 100;

        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) {
            return $this->image_lib->display_errors();
        }
    }

    public function resizeImage($source_image)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 1920;
        $config['height']       = 1920;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) 
        {
            echo $this->image_lib->display_errors();
        }
    }
    
    public function overlayWatermark($source_image)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['wm_type'] = 'overlay';
        $config['wm_overlay_path'] = APPPATH.'/../assets/images/wmlogo.png';     //the overlay image
        // $config['wm_x_transp'] = 0;
        // $config['wm_y_transp'] = 0;
        $config['wm_vrt_offset'] = 0;
        $config['wm_hor_offset'] = 20;
        $config['wm_quality'] = 80;
        $config['wm_opacity'] = 90;
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'left';
        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) 
        {
            echo $this->image_lib->display_errors();
        }
    }

    public function API_destroyLampiran($arsip_id, $lampiran_id) {
        // hanya post request
        if($this->input->method() != 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        // cari arsip
        $arsip_id = preg_replace('/[^0-9]/', '', $arsip_id);
        if(!$arsip_id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $arsip = $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $arsip_id);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }
        $arsip = $arsip->get()
            ->row_array();
        // cek apakah arsip ditemukan
        if(!$arsip) {
            // jika tidak ditemukan, return not found
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cari lampiran
        $lampiran = $this->db->select('*')
            ->from('tbl_lampiran')
            ->where('arsip_id', $arsip['id'])
            ->where('id', $lampiran_id)
            ->get()
            ->row_array();
        // cek apakah lampiran ditemukan
        if(!$lampiran) {
            // jika lampiran tidak ditemukan
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Lampiran tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // delete file lampiran
        is_file(APPPATH.DIRECTORY_SEPARATOR.'..'.$lampiran['url']) && unlink(APPPATH.DIRECTORY_SEPARATOR.'..'.$lampiran['url']);
        $this->db->where('id', $lampiran['id'])
            ->update('tbl_lampiran', [
                'is_deleted' => 1,
                'deleted_at' => date('c')
            ]);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Lampiran berhasil dihapus',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_publish($id) {
        // hanya post request
        if($this->input->method() !== 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        // cari arsip
        $id = preg_replace('/[^0-9]/', '', $id);
        if(!$id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $arsip = $this->db->select('id')
            ->from('tbl_arsip')
            ->where('id', $id);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }
        $arsip = $arsip->get()
            ->row_array();
        if(!$arsip) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $this->db->where('id', $arsip['id'])
            ->update('tbl_arsip', [
                'status' => 2
            ]);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil dipublikasi',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_draft($id) {
        // hanya post request
        if($this->input->method() !== 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }
        // cari arsip
        // cari arsip
        $id = preg_replace('/[^0-9]/', '', $id);
        if(!$id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $arsip = $this->db->select('id')
            ->from('tbl_arsip')
            ->where('id', $id);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }
        $arsip = $arsip->get()
            ->row_array();
        if(!$arsip) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $this->db->where('id', $arsip['id'])
            ->update('tbl_arsip', [
                'status' => 1
            ]);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil disimpan sebagai draft',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_restore($id) {
        // hanya post request
        if($this->input->method() !== 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $id = preg_replace('/[^0-9]/', '', $id);
        if(!$id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cari arsip
        $arsip = $this->db->select('id')
            ->from('tbl_arsip')
            ->where('id', $id);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }
        $arsip = $arsip->get()
            ->row_array();
            
        if(!$arsip) {
            // jika tidak ditemukan, return not found
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $this->db->where('id', $arsip['id'])
            ->update('tbl_arsip', [
                'status' => 1
            ]);
        
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil dikembalikan menjadi draft.',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_destroy($id) {
        // hanya post request
        if($this->input->method() !== 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Method not allowed.',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $id = preg_replace('/[^0-9]/', '', $id);
        if(!$id) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // cari arsip
        $arsip = $this->db->select('id')
            ->from('tbl_arsip')
            ->where('id', $id);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsip = $arsip->where('level', 2);
        }
        $arsip = $arsip->get()
            ->row_array();
            
        if(!$arsip) {
            // jika tidak ditemukan, return not found
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Arsip tidak ditemukan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        $this->db->where('id', $arsip['id'])
            ->update('tbl_arsip', [
                'status' => 3
            ]);
        
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Arsip berhasil dikembalikan menjadi draft.',
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }

    public function API_last5() {
        $arsips = $this->db->select('*')
            ->from('tbl_arsip')
            ->where('status <>', 3);
        if(in_array('arsip_publik', $this->myroles)) {
            $arsips = $arsips->where('level', 2);
        }
        $arsips = $arsips->order_by('id', 'desc')
            ->limit(5)
            ->get()
            ->result_array();
        
        foreach($arsips as $key => $arsip) {
            // tambahkan klasifikasi
            if($arsip['klasifikasi_id']) {
                $arsips[$key]['klasifikasi'] = $this->db->select('*')
                    ->from('tbl_klasifikasi')
                    ->where('id', $arsip['klasifikasi_id'])
                    ->get()
                    ->row_array();
            }
            // tambahkan pengolah
            if($arsip['admin_id']) {
                $arsips[$key]['admin'] = $this->db->select('id, name')
                    ->from('users')
                    ->where('id', $arsip['admin_id'])
                    ->get()
                    ->row_array();
            }
            // tambahkan lampiran
            $arsips[$key]['lampirans'] = [];
			$lampirans = $this->lampiran_model->getTop2LampiransByArsip($arsip['id']);
			$lampiransCount = $this->lampiran_model->countLampiranByArsip($arsip['id']);
			if($lampiransCount) {
				foreach ($lampirans as $lampiran) {
					array_push($arsips[$key]['lampirans'], [
						'type' => $lampiran['type'],
						'url' => $lampiran['url']
					]);
				}
			}
			if($lampiransCount > 2) {
				array_push($arsips[$key]['lampirans'], [
					'type' => 'number',
					'url' => $lampiransCount - 2
				]);
			}
            // format tanggal
            $arsips[$key]['tanggal_formatted'] = $arsip['tanggal'] ? date('d M Y', strtotime($arsip['tanggal'])) : '';
        }
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $arsips,
                'csrf' => $this->security->get_csrf_hash()
            ])); 
    }

    public function API_chartData() {
        $end = date('Y-m-d');
        $begin = date('Y-m-d', strtotime("-2 week", strtotime($end)));

        $data = $this->db->select('DATE_FORMAT(created_at, "%Y-%m-%d") as date, count(id) as count')
            ->from('tbl_arsip')
            ->where('created_at IS NOT NULL', null, false)
            ->where('created_at >=', $begin)
            ->where('status', 2)
            ->group_by('date')
            ->get()
            ->result_array();

        if(!$data) {
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => [],
                    'csrf' => $this->security->get_csrf_hash()
                ])); 
        }

        $begin = new DateTime($begin);
        $end = new DateTime(date('Y-m-d', strtotime("+1 day", strtotime($end))));
        $interval = DateInterval::createFromDateString('1 day');
        $periode = new DatePeriod($begin, $interval, $end);

        $result = [];
        foreach ($periode as $key => $date) {
            $currentDate = $date->format('Y-m-d');
            $search = array_search($currentDate, array_column($data, 'date'));
            if(is_int($search)) {
                $data[$search]['formatted_date'] = $date->format('d/m');
                array_push($result, $data[$search]);
            } else {
                array_push($result, [
                    'date' => $currentDate,
                    'formatted_date' => $date->format('d/m'),
                    'count' => 0
                ]);
            }
        }

        return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode([
            'success' => true,
            'data' => $result,
            'csrf' => $this->security->get_csrf_hash()
        ])); 
    }
}

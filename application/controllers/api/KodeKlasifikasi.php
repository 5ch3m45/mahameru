<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KodeKlasifikasi extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('klasifikasi_model');
    }

	public function index() {
        $response = [
            'success' => true
        ];
        
		return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT));
	}

    public function store() {
        if(!$this->input->post()) {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                ]));
        }

        $input = $this->input->post(NULL, TRUE);

        // validasi kode
        $this->form_validation->set_rules('kode', 'Kode', 'numeric|required', [
            'required' => 'Kode tidak boleh kosong',
            'numeric' => 'Kode tidak valid',
        ]);

        // validasi nama
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required' => 'Nama tidak boleh kosong'
        ]);

        // cek kode sudah ada apa belum
        $kode = $this->klasifikasi_model->getOneByKode((int)$input['kode']);
        // jika ada kode
        $kodeError = '';
        if($kode) {
            $kodeError = 'Kode sudah terdaftar';
        }

        // jalankan validasi
        if($this->form_validation->run() == false || @$kodeError) {
            return $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'success' => false,
                        'validation' => [
                            'kode' => form_error('kode') ? form_error('kode') : @$kodeError,
                            'nama' => form_error('nama')
                        ],
                        'csrf' => $this->security->get_csrf_hash()
                    ]));
        }

        // inisiasi data yang akan disimpan ke database
        $data = [
            'kode' => (int)$input['kode'],
            'nama' => trim($input['nama']),
            'deskripsi' => @$input['deskripsi'],
            'created_at' => date('c'),
            'updated_at' => date('c')
        ];

        // simpan data ke database dan dapatkan ID
        $klasifikasiID = $this->klasifikasi_model->store($data);

        // jika tidak tersimpan
        if(!$klasifikasiID) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan',
                    'csrf' => $this->security->get_csrf_hash()
                ]));
        }

        // dapatkan klasifikasi berdasarkan ID
        $klasifikasi = $this->klasifikasi_model->getOne($klasifikasiID);
        
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $klasifikasi,
                'csrf' => $this->security->get_csrf_hash()
            ]));
    }
}

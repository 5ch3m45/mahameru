<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'admin_create' => array(
        array(
			'label' => 'Nama',
			'rules' => 'required|min_length[3]|max_length[30]',
			'field' => 'nama',
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ),
    ),
	'login' => array(
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'password',
			'label' => 'Kata sandi',
			'rules' => 'required'
        ),
        array(
            'field' => 'phrase',
            'label' => 'Verifikasi',
            'rules' => 'required'
        )
	),
    'forgot_password' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        )
    ),
	'reset_password' => array(
		array(
			'field' => 'password',
			'label' => 'Kata sandi',
			'rules' => 'required|min_length[8]'
		),
		array(
			'field' => 'confirm_password',
			'label' => 'Konfirmasi kata sandi',
			'rules' => 'required|matches[password]'
		)
	),
    'email' => array(
        array(
            'field' => 'emailaddress',
            'label' => 'EmailAddress',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|alpha'
        ),
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required'
        ),
        array(
            'field' => 'message',
            'label' => 'MessageBody',
            'rules' => 'required'
        )
    )
);

$config['error_prefix'] = '<small class="text-danger">';
$config['error_suffix'] = '</small>';
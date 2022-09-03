<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'admin_create' => array(
            array(
                    'field' => 'nama',
                    'label' => 'Nama',
                    'rules' => 'required|min_length[3]|max_length[30]'
            ),
            array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|valid_email'
            ),
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Authentication extends CI_Controller {
    function __construct() {
		parent::__construct();
        $this->lang->load('auth');
        $this->load->helper('string');
        $this->load->library('session');
        $this->load->model([
            'admin_model',
            'group_model'
        ]);
	}

    
}
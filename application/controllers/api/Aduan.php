<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Aduan extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model([
            'aduan_model',
            'aduan_timeline_model',
        ]);
        $this->load->library('form_validation');
        $this->load->helper('formatter_helper');
    }

    
}

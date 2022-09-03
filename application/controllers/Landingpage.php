<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;

class Landingpage extends CI_Controller {
	
	public function index() {
		$captcha = new CaptchaBuilder();
		
		$_SESSION['phrase'] = $captcha->getPhrase();
		$data['captcha'] = $captcha->build()->inline();

		$this->load->view('landingpage', $data);
	}
	
	public function encrypt() {
		$this->load->library('encryption');
		var_dump(bin2hex($this->encryption->create_key(16)));
	}
}

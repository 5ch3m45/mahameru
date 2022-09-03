<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;
class Aduan extends CI_Controller {
	public function show() {
		$captcha = new CaptchaBuilder();
		
		$_SESSION['phrase'] = $captcha->getPhrase();
		$data['captcha'] = $captcha->build()->inline();
		$this->load->view('aduan_detail', $data);
	}
}

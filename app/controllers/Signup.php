<?php

class Signup extends Controller {
	public function index(){
		$data['style'] = BASEURL.'/css/signup-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/index');
		$this->view('templates/footer');
	}
}
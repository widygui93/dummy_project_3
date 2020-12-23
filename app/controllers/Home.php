<?php

class Home extends Controller{
	public function index(){
		$data['style'] = BASEURL.'/css/style.css';
		$data['script'] = BASEURL.'/js/script-home.js';
		$this->view('templates/header', $data);
		$this->view('home/index');
		$this->view('templates/footer', $data);
	}

}
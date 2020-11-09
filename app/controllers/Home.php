<?php

class Home extends Controller{
	public function index(){
		$data['style'] = BASEURL.'/css/style.css';
		$this->view('templates/header', $data);
		$this->view('home/index');
		$this->view('templates/footer');
	}

}
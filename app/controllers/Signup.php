<?php
class Signup extends Controller {
	public function index(){
		$data['style'] = BASEURL.'/css/signup-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/index');
		$this->view('templates/footer');
	}
	public function student(){
		$data['style'] = BASEURL.'/css/signup-main-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/student');
		$this->view('templates/footer');
	}
	public function signupStudent(){
		$result = $this->model('Signup_model')->signupStudent($_POST);
		Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL . '/signup/student');
		exit;
	}
	public function teacher(){
		$data['style'] = BASEURL.'/css/signup-main-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/teacher');
		$this->view('templates/footer');
	}
	public function signupTeacher(){
		$result = $this->model('Signup_model')->signupTeacher($_POST);
		Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL . '/signup/teacher');
		exit;
	}
}
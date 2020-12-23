<?php
class Signup extends Controller {
	public function index(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/signup-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/index');
		$this->view('templates/footer');
	}
	public function student(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/signup-main-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/student');
		$this->view('templates/footer');
	}
	public function signupStudent(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		if( $this->model('Verify_model')->isDataEmpty($_POST) ) return $this->model('Verify_model')->goHome();
		$result = $this->model('Signup_model')->signupStudent($_POST);
		Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL . '/signup/student');
		exit;
	}
	public function teacher(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/signup-main-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/teacher');
		$this->view('templates/footer');
	}
	public function signupTeacher(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		if( $this->model('Verify_model')->isDataEmpty($_POST) ) return $this->model('Verify_model')->goHome();
		$result = $this->model('Signup_model')->signupTeacher($_POST);
		Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL . '/signup/teacher');
		exit;
	}
}
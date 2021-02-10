<?php
class Login extends Controller {
	public function index(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/login-style.css';
		$this->view('templates/header', $data);
		$this->view('login/index');
		$this->view('templates/footer');
	}
	public function student(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/login-main-style.css';
		$this->view('templates/header', $data);
		$this->view('login/student');
		$this->view('templates/footer');
	}
	public function loginStudent(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		if( $this->model('Verify_model')->isDataEmpty($_POST) ) return $this->model('Verify_model')->goHome();
		$result = $this->model('Login_model')->login($_POST, 'student');
		$this->model('Verify_model')->goHome();
	}
	public function teacher(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/login-main-style.css';
		$this->view('templates/header', $data);
		$this->view('login/teacher');
		$this->view('templates/footer');
		
	}
	public function loginTeacher(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		if( $this->model('Verify_model')->isDataEmpty($_POST) ) return $this->model('Verify_model')->goHome();
		$result = $this->model('Login_model')->login($_POST, 'teacher');
		$this->model('Verify_model')->goHome();
		
	}
}
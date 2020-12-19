<?php
class Login extends Controller {
	public function index(){
		if( $this->model('Login_model')->isUserLogin() ) return $this->model('Login_model')->goHome();
		$data['style'] = BASEURL.'/css/login-style.css';
		$this->view('templates/header', $data);
		$this->view('login/index');
		$this->view('templates/footer');
	}
	public function student(){
		if( $this->model('Login_model')->isUserLogin() ) return $this->model('Login_model')->goHome();
		$data['style'] = BASEURL.'/css/login-main-style.css';
		$this->view('templates/header', $data);
		$this->view('login/student');
		$this->view('templates/footer');
	}
	public function loginStudent(){
		if( $this->model('Login_model')->isUserLogin() ) return $this->model('Login_model')->goHome();
		if( $this->model('Login_model')->isDataEmpty($_POST) ) return $this->model('Login_model')->goHome();
		$result = $this->model('Login_model')->login($_POST, 'student');
		if( $result['title'] == 'Failed' ) return $this->model('Login_model')->setFlash($result, 'student');
		$this->model('Login_model')->setSession($_POST["username"], 'student');
		$this->model('Login_model')->goHome();
	}
	public function teacher(){
		if( $this->model('Login_model')->isUserLogin() ) return $this->model('Login_model')->goHome();
		$data['style'] = BASEURL.'/css/login-main-style.css';
		$this->view('templates/header', $data);
		$this->view('login/teacher');
		$this->view('templates/footer');
		
	}
	public function loginTeacher(){
		if( $this->model('Login_model')->isUserLogin() ) return $this->model('Login_model')->goHome();
		if( $this->model('Login_model')->isDataEmpty($_POST) ) return $this->model('Login_model')->goHome();
		$result = $this->model('Login_model')->login($_POST, 'teacher');
		if( $result['title'] == 'Failed' ) return $this->model('Login_model')->setFlash($result, 'teacher');
		$this->model('Login_model')->setSession($_POST["username"], 'teacher');
		$this->model('Login_model')->goHome();
		
	}
}
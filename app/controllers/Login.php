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
        echo "login student";
        var_dump($_POST);
		// $result = $this->model('Signup_model')->signupStudent($_POST);
		// Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL );
		exit;
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
		$result = $this->model('Login_model')->loginTeacher($_POST);
		if( $result['title'] == 'Failed' ) return $this->model('Login_model')->setFlash($result);
		$this->model('Login_model')->setSessionTeacher($_POST["username"]);
		$this->model('Login_model')->goHome();
		
	}
}
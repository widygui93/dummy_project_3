<?php
class Login extends Controller {
	public function index(){
		$data['style'] = BASEURL.'/css/login-style.css';
		$this->view('templates/header', $data);
		$this->view('login/index');
		$this->view('templates/footer');
	}
	public function student(){
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
		$data['style'] = BASEURL.'/css/login-main-style.css';
		$this->view('templates/header', $data);
		$this->view('login/teacher');
		$this->view('templates/footer');
	}
	public function loginTeacher(){
		$result = $this->model('Login_model')->loginTeacher($_POST);
		if( $result['title'] == 'Failed' ){
			Flasher::setFlash($result['icon'], $result['title'], $result['text']);
			header('Location: ' . BASEURL . '/login/teacher');
			exit;
		}else{
			$_SESSION["login-teacher"] = true;
			$_SESSION["username-teacher"] = $_POST["username"];

			header('Location: ' . BASEURL );
			exit;
		}
	}
}
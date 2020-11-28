<?php
class Signup extends Controller {
	public function index(){
		$data['style'] = BASEURL.'/css/signup-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/index');
		$this->view('templates/footer');
	}
	public function student(){
		$data['style'] = BASEURL.'/css/signup-student-style.css';
		$this->view('templates/header', $data);
		$this->view('signup/student');
		$this->view('templates/footer');
	}
	public function signupStudent(){
		if( $this->model('Signup_model')->signupStudent($_POST) > 0 ){
			Flasher::setFlash('success', 'Success', 'Register successfully', 'success');
			header('Location: ' . BASEURL . '/signup/student');
			exit;
		} else{
			Flasher::setFlash('error', 'Failed', 'Register failed', 'error');
			header('Location: ' . BASEURL . '/signup/student');
			exit;
		}
	}
}
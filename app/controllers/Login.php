<?php
class Login extends Controller {
	public function index(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/login-style.css';
		$twig = $this->view();
		echo $twig->render('/templates/header.html.twig', 
			[
				'style' => $data['style'], 
				'BASEURL' => BASEURL ,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false,
				'username_teacher' => $_SESSION['username_teacher'] ?? '',
				'username_student' => $_SESSION['username_student'] ?? ''
			]
		);
		echo $twig->render('/login/index.html.twig', ['BASEURL' => BASEURL ]);
		echo $twig->render('/templates/footer.html.twig',
			[
				'BASEURL' => BASEURL 
			]
		);
	}
	public function student(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/login-main-style.css';
		$twig = $this->view();
		echo $twig->render('/templates/header.html.twig', 
			[
				'style' => $data['style'], 
				'BASEURL' => BASEURL ,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false,
				'username_teacher' => $_SESSION['username_teacher'] ?? '',
				'username_student' => $_SESSION['username_student'] ?? ''
			]
		);
		echo $twig->render('/login/student.html.twig', 
			[
				'flash' => Flasher::flash() ?? '' ,
				'BASEURL' => BASEURL 
			]
		);
		echo $twig->render('/templates/footer.html.twig',
			[
				'BASEURL' => BASEURL 
			]
		);
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
		$twig = $this->view();
		echo $twig->render('/templates/header.html.twig', 
			[
				'style' => $data['style'], 
				'BASEURL' => BASEURL ,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false,
				'username_teacher' => $_SESSION['username_teacher'] ?? '',
				'username_student' => $_SESSION['username_student'] ?? ''
			]
		);
		echo $twig->render('/login/teacher.html.twig', 
			[
				'flash' => Flasher::flash() ?? '' ,
				'BASEURL' => BASEURL 
			]
		);
		echo $twig->render('/templates/footer.html.twig',
			[
				'BASEURL' => BASEURL 
			]
		);
		
	}
	public function loginTeacher(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		if( $this->model('Verify_model')->isDataEmpty($_POST) ) return $this->model('Verify_model')->goHome();
		$result = $this->model('Login_model')->login($_POST, 'teacher');
		$this->model('Verify_model')->goHome();
		
	}
}
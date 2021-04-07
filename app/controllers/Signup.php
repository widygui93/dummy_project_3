<?php
class Signup extends Controller {
	public function index(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/signup-style.css';
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
		echo $twig->render('/signup/index.html.twig', ['BASEURL' => BASEURL ]);
		echo $twig->render('/templates/footer.html.twig',
			[
				'BASEURL' => BASEURL 
			]
		);
	}
	public function student(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		$data['style'] = BASEURL.'/css/signup-main-style.css';
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
		echo $twig->render('/signup/student.html.twig', 
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
		echo $twig->render('/signup/teacher.html.twig', 
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
	public function signupTeacher(){
		if( $this->model('Verify_model')->isUserLogin() ) return $this->model('Verify_model')->goHome();
		if( $this->model('Verify_model')->isDataEmpty($_POST) ) return $this->model('Verify_model')->goHome();
		$result = $this->model('Signup_model')->signupTeacher($_POST);
		Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL . '/signup/teacher');
		exit;
	}
}
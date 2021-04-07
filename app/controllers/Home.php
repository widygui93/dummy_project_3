<?php

class Home extends Controller{
	public function index(){
		$data['style'] = BASEURL.'/css/style.css';
		$data['script'] = BASEURL.'/js/script-home.js';

		$twig = $this->view();
		echo $twig->render('/templates/header.html.twig', 
			[
				'style' => $data['style'], 
				'BASEURL' => BASEURL,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false,
				'username_teacher' => $_SESSION['username_teacher'] ?? '',
				'username_student' => $_SESSION['username_student'] ?? ''
			]
		);
		echo $twig->render('/home/index.html.twig', 
			[
				'BASEURL' => BASEURL,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false
			]
		);
		echo $twig->render('/templates/footer.html.twig',
			[
				'script' => $data['script'],
				'BASEURL' => BASEURL 
			]
		);
	}

}
<?php
class Dashboard_teacher extends Controller{
    public function index(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome(); 

        $data['style'] = BASEURL.'/css/dashboard-teacher-style.css';
        $data['style-tutorial'] = BASEURL.'/css/tutorial-style.css';
        $data['script'] = BASEURL.'/js/script-dashboard-teacher.js';
        $data['script-modal-detail-tutorial'] = BASEURL.'/js/script-modal-detail-tutorial.js';
        $data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
        $data['tutorials'] = $this->model('Dashboard_teacher_model')->getTutorialsBy($_SESSION["username_teacher"]);
        $data['total-tutorials'] = $this->model('Dashboard_teacher_model')->getTotalTutorialsBy($_SESSION["username_teacher"]);
        $twig = $this->view();
		echo $twig->render('/templates/header.html.twig', 
			[
				'style' => $data['style'], 
                'style_tutorial' => $data['style-tutorial'],
				'BASEURL' => BASEURL,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false,
				'username_teacher' => $_SESSION['username_teacher'] ?? '',
				'username_student' => $_SESSION['username_student'] ?? ''
			]
		);
		echo $twig->render('/dashboard-teacher/index.html.twig', 
			[
				'BASEURL' => BASEURL,
                'flash' => Flasher::flash() ?? ''
			]
		);
        echo empty( $data['tutorials'] ) 
            ? $twig->render('/tutorial/no-tutorial.html.twig') : 
              $twig->render('/tutorial/index.html.twig', 
                [
                    'tutorials' => $data['tutorials'], 
                    'total_tutorials' => $data['total-tutorials'],
                    'BASEURL' => BASEURL
                ]
              );
		echo $twig->render('/templates/footer.html.twig',
			[
				'script' => $data['script'],
                'script_axios' => $data['script-axios'],
                'script_modal_detail_tutorial' => $data['script-modal-detail-tutorial'],
				'BASEURL' => BASEURL 
			]
		);
    }
    public function upload(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome();
        if( $this->model('Verify_model')->isDataEmpty($_POST) ) return $this->model('Verify_model')->goHome();
        $result = $this->model('Dashboard_teacher_model')->createTutorial($_POST);
		Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL . '/dashboard_teacher');
		exit;
    }

}
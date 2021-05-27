<?php

class Home extends Controller{
	public function index(){
		$data['style'] = BASEURL.'/css/style.css';
		$data['script'] = BASEURL.'/js/script-home.js';
		$data['script-modal-detail-tutorial'] = BASEURL.'/js/script-modal-detail-tutorial.js';
		$data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
		$data['script-load-more'] = BASEURL.'/js/script-load-more.js';
		$data['tutorials'] = $this->model('Home_model')->getTutorials();
		$data['total-tutorials'] = $this->model('Home_model')->getTotalTutorials();

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
		echo $twig->render('/home/call-to-action.html.twig',
			[
				'BASEURL' => BASEURL,
				'login_teacher' => $_SESSION['login_teacher'] ?? false,
				'login_student' => $_SESSION['login_student'] ?? false
			]
		);

		if(isset( $_SESSION['login_teacher'] )){
			
            echo $twig->render('/tutorial/index.html.twig',
				[
					'tutorials' => $data['tutorials'], 
					'total_tutorials' => $data['total-tutorials'],
					'BASEURL' => BASEURL
				]
			);
        } elseif(isset( $_SESSION['login_student'] )){
           
            // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja
            echo "ini view student";

        } else {
            // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja
            // klu tombol purchase di klik nanti minta login dulu sebagai student
            // echo "ini view kosong";
			echo $twig->render('/tutorial/student-non-dashboard.html.twig',
				[
					'tutorials' => $data['tutorials'], 
					'total_tutorials' => $data['total-tutorials'],
					'BASEURL' => BASEURL
				]
			);
            
        }

		echo $twig->render('/home/static-view.html.twig');

		echo $twig->render('/templates/footer.html.twig',
			[
				'script' => $data['script'],
				'script_axios' => $data['script-axios'],
                'script_modal_detail_tutorial' => $data['script-modal-detail-tutorial'],
                'script_load_more' => $data['script-load-more'],
				'BASEURL' => BASEURL 
			]
		);
	}

}
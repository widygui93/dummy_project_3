<?php
class Dashboard_teacher extends Controller{
    public function index(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome(); 

        $data['style'] = BASEURL.'/css/dashboard-teacher-style.css';
        $data['style-tutorial'] = BASEURL.'/css/tutorial-style.css';
        $data['script'] = BASEURL.'/js/script-dashboard-teacher.js';
        $data['script-modal-detail-tutorial'] = BASEURL.'/js/script-modal-detail-tutorial.js';
        $data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
        $data['script-load-more'] = BASEURL.'/js/script-load-more.js';
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
              $twig->render('/tutorial/teacher.html.twig', 
                [
                    'tutorials' => $data['tutorials'], 
                    'total_tutorials' => $data['total-tutorials'],
                    // 'login_teacher' => $_SESSION['login_teacher'],
                    'BASEURL' => BASEURL
                ]
              );
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
    public function upload(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome();
        $result = $this->model('Dashboard_teacher_model')->createTutorial($_POST);
		Flasher::setFlash($result['icon'], $result['title'], $result['text']);
		header('Location: ' . BASEURL . '/Dashboard_teacher');
		exit;
    }

    public function revoke(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome();
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $id = $requestArrayData['id'];

        $responseArrayData = $this->model('Dashboard_teacher_model')->revokeTutorial($id);
        $responseJsonData = json_encode($responseArrayData);
        echo $responseJsonData;
 
    }

    public function restore(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome();
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $id = $requestArrayData['id'];

        $responseArrayData = $this->model('Dashboard_teacher_model')->restoreTutorial($id);
        $responseJsonData = json_encode($responseArrayData);
        echo $responseJsonData;

    }

    public function getDataToDisplayBeforeUpdate(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome();
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $id = $requestArrayData['id'];

        $responseArrayData = $this->model('Dashboard_teacher_model')->getDataTutorialToDisplayBeforeUpdate($id);
        $responseJsonData = json_encode($responseArrayData);
        echo $responseJsonData;

    }
    
    public function update(){
        if( !$this->model('Verify_model')->isLoginAsTeacher() ) return $this->model('Verify_model')->goHome();
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $id = $requestArrayData['id'];
        $prize = $requestArrayData['prize'];
        $desc = $requestArrayData['desc'];

        $responseArrayData = $this->model('Dashboard_teacher_model')->updateTutorial($id, $prize, $desc);
        $responseJsonData = json_encode($responseArrayData);
        echo $responseJsonData;
    }

}
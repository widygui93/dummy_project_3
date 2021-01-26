<?php
class Dashboard_teacher extends Controller{
    public function index(){
        if( $this->model('Verify_model')->isLoginAsTeacher() ) {
            $data['style'] = BASEURL.'/css/dashboard-teacher-style.css';
            $data['style-tutorial'] = BASEURL.'/css/tutorial-style.css';
            $data['script'] = BASEURL.'/js/script-dashboard-teacher.js';
            $data['script-modal-detail-tutorial'] = BASEURL.'/js/script-modal-detail-tutorial.js';
            $data['tutorials'] = $this->model('Dashboard_teacher_model')->getTutorialsBy($_SESSION["username-teacher"]);
            $this->view('templates/header', $data);
            $this->view('dashboard-teacher/index');
            $this->view('tutorial/index', $data);
            $this->view('templates/footer', $data);
        } else {
            return $this->model('Verify_model')->goHome();
        }
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
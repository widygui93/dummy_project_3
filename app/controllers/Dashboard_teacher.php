<?php
class Dashboard_teacher extends Controller{
    public function index(){
        if( $this->model('Verify_model')->isLoginAsTeacher() ) {
            $data['style'] = BASEURL.'/css/dashboard-teacher-style.css';
            $data['script'] = BASEURL.'/js/script-dashboard-teacher.js';
            $this->view('templates/header', $data);
            $this->view('dashboard-teacher/index');
            $this->view('templates/footer', $data);
        } else {
            return $this->model('Verify_model')->goHome();
        }
    }
    public function upload(){
        var_dump($_POST);
        var_dump($_SESSION);
    }

}
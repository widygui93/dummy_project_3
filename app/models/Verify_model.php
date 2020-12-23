<?php
class Verify_model {
    public function isUserLogin(){
        return empty($_SESSION["login-teacher"]) && empty($_SESSION["login-student"]) ? false : true;
    }
    public function goHome(){
        header('Location: ' . BASEURL );
		exit;
    }
    public function isDataEmpty(array $data): bool{
        return empty($data) ? true : false;
    }
    public function isLoginAsStudent(){
        return empty($_SESSION["login-student"]) ? false : true;
    }
    public function isLoginAsTeacher(){
        return empty($_SESSION["login-teacher"]) ? false : true;
    }

}
<?php
class Verify_model {
    public function isUserLogin(){
        return empty($_SESSION["login_teacher"]) && empty($_SESSION["login_student"]) ? false : true;
    }
    public function goHome(){
        header('Location: ' . BASEURL );
		exit;
    }

    public function isLoginAsStudent(){
        return empty($_SESSION["login_student"]) ? false : true;
    }
    public function isLoginAsTeacher(){
        return empty($_SESSION["login_teacher"]) ? false : true;
    }

    // ini untuk menjaga agar tidak bisa sembarang akses dari url tanpa memberikan data
    public function isRequestDataEmpty(string $reqData): bool{
        return empty($reqData) ? true : false;
    }


}
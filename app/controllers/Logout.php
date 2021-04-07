<?php
class Logout {
	public function index(){
        unset($_SESSION["login_teacher"]);
        unset($_SESSION["username_teacher"]);
        unset($_SESSION["login_student"]);
        unset($_SESSION["username_student"]);
        header('Location: ' . BASEURL );
        exit;
	}
	
}
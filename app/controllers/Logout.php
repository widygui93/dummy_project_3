<?php
class Logout extends Controller {
	public function index(){
        unset($_SESSION["login-teacher"]);
        unset($_SESSION["username-teacher"]);
        unset($_SESSION["login-student"]);
        unset($_SESSION["username-student"]);
        header('Location: ' . BASEURL );
        exit;
	}
	
}
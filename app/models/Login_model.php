<?php
class Login_model extends Model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function login($data, $table){
        if( !$this->doesMandatoryDataFilled(
            array(
                "username" => $data["username"],
                "password" => $data["password"]
            )
        ) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data username and password are mandatory'
            ];
        } else{
            $data["username"] = $this->purify($data["username"]);
            $data['password'] = $this->purify($data['password']);

            $query = "SELECT * FROM $table WHERE username=:username";
            $this->db->query($query);
            $this->db->bind(':username', strtolower(stripslashes($data['username'])));
            $this->db->execute();

		    // cek username ada di db atau tidak
            if( $this->db->rowCount() === 1 ){
                // cek password sama atau tidak
                $row = $this->db->single();
                if( password_verify($data['password'], $row["password"]) ){

                    return [
                        'icon' => 'success',
                        'title' => 'Success',
                        'text' => 'Login successfully'
                    ];
                } else {
                    return [
                        'icon' => 'error',
                        'title' => 'Failed',
                        'text' => 'Username or Password are invalid'
                    ];
                }
            } else {
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Username or Password are invalid'
                ];
            }
        }
    }
    public function isUserLogin(){
        return empty($_SESSION["login-teacher"]) && empty($_SESSION["login-student"]) ? false : true;
    }
    public function goHome(){
        header('Location: ' . BASEURL );
		exit;
    }
    public function isDataEmpty(array $data): bool {
        return empty($data) ? true : false;
    }
    public function setFlash($result, $method){
        Flasher::setFlash($result['icon'], $result['title'], $result['text']);
        header('Location: ' . BASEURL . '/login/' . $method . '');
		exit;
    }
    public function setSession($username, $user){
        if( $user == 'teacher' ){
            $_SESSION["login-teacher"] = true;
		    $_SESSION["username-teacher"] = strtolower(stripslashes($username));
        } else{
            $_SESSION["login-student"] = true;
		    $_SESSION["username-student"] = strtolower(stripslashes($username));
        }
        
    }
}
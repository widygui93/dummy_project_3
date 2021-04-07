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

            $numOfRecord = R::count( $table, ' username = ? ' , [ strtolower(stripslashes($data['username'])) ] );

		    // cek username ada di db atau tidak
            if( $numOfRecord === 1 ){
                // cek password sama atau tidak
                $userName = strtolower(stripslashes($data['username']));
                $record = R::findOne( $table, ' username = ? ', [ $userName ] );
                $passwd = $record->export()['password'];
                if( password_verify($data['password'], $passwd) ){
                    R::close();

                    $this->setSession($userName, $table);

                } else {
                    R::close();
                    $result = [
                        'icon' => 'error',
                        'title' => 'Failed',
                        'text' => 'Username or Password are invalid'
                    ];
                    $this->setFlash($result ,$table);
                }
            } else {
                R::close();
                $result = [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Username or Password are invalid'
                ];
                $this->setFlash($result ,$table);
            }
        }
    }
    private function setFlash($result, $method){
        Flasher::setFlash($result['icon'], $result['title'], $result['text']);
        header('Location: ' . BASEURL . '/login/' . $method . '');
		exit;
    }
    private function setSession($username, $user){
        if( $user == 'teacher' ){
            $_SESSION["login_teacher"] = true;
		    $_SESSION["username_teacher"] = strtolower(stripslashes($username));
        } else{
            $_SESSION["login_student"] = true;
		    $_SESSION["username_student"] = strtolower(stripslashes($username));
        }
        
    }
}
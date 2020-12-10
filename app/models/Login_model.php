<?php
class Login_model extends Model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function loginTeacher($data){
        $data["username"] = $this->purify($data["username"]);
        $data['password'] = $this->purify($data['password']);

        $query = "SELECT * FROM teacher WHERE username=:username";
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
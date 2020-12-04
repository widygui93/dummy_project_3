<?php
class Signup_model extends Model {
    private $table = 'student';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function signupStudent($data){
        $reg_date = $this->getRegisterDate();
        $coin = 100;
        $profile_pic = 'student.png';
        $id = $this->createRandomID();
        $data_student = array(
            "name" => $data['name'], 
            "username" => $data['username'], 
            "email" => $data['email'], 
            "phone" => $data['phone'],
            "password" => $data['password'],
            "password-confirm" => $data['password-confirm']
        );
        if( !$this->doesMandatoryDataFilled($data_student) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data name, username, email, phone no, password and password confirm are mandatory',
                'type' => 'error'
            ];
        } elseif( $this->isUsernameExist($data_student['username'], $this->table) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Username already exist',
                'type' => 'error'
            ];
        } elseif( $this->isBreak($data_student['username'], "/^(?=.*\d)(?=.*[a-zA-Z]).{6,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Username Format: Combination of letters and numbers, Length: 6 - 12',
                'type' => 'error'
            ];

        } elseif( $this->isBreak($data_student['name'], "/^[a-zA-Z .,]*$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Name Format: letters, space, comma and period',
                'type' => 'error'
            ];
        } elseif( $this->isBreak($data_student['email'], "/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Email must follow this format: yourname@domain.com(.id)',
                'type' => 'error'
            ];
        } elseif( $this->isBreak($data_student['phone'], "/^\d{10,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Phone Format: number only, Length: 10 - 12 digit',
                'type' => 'error'
            ];
        } elseif( $this->isBreak($data_student['password'], "/^[\w@-]{8,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Password Allow letter, number, @, -, _ Length: 10 - 12 digit',
                'type' => 'error'
            ];
        } elseif( $this->isNotMatch($data_student['password'],$data_student['password-confirm']) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Password does not match with Confirm Password',
                'type' => 'error'
            ];
        } else {
            $data_student['name'] = $this->purify($data_student['name']);
            $data_student['username'] = $this->purify($data_student['username']);
            $data_student['email'] = $this->purify($data_student['email']);
            $data_student['phone'] = $this->purify($data_student['phone']);
            $data_student['password'] = $this->purify($data_student['password']);
            $data_student['password-confirm'] = $this->purify($data_student['password-confirm']);
            // enkripsi password
            $password = password_hash($data_student['password'], PASSWORD_DEFAULT);

            $query = "INSERT INTO " . $this->table . " VALUES (:id, :nama, :username, :email, :reg_date, :coin, :password, :profile_pic, :phone_no)";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $this->db->bind(':nama', strtolower(stripslashes($data_student['name'])));
            $this->db->bind(':username', strtolower(stripslashes($data_student['username'])));
            $this->db->bind(':email', strtolower(stripslashes($data_student['email'])));
            $this->db->bind(':reg_date', $reg_date);
            $this->db->bind(':coin', $coin);
            $this->db->bind(':password', $password);
            $this->db->bind(':profile_pic', $profile_pic);
            $this->db->bind(':phone_no', stripslashes($data_student['phone']));
            $this->db->execute();

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Register successfully'
            ];

        }
        
    }
}
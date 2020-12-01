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
            $data['name'], 
            $data['username'], 
            $data['email'], 
            $data['phone'],
            $data['password'],
            $data['password-confirm']
        );
        if( !$this->isDataAvailable($data_student) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data name, username, email, phone no, password and password confirm are mandatory',
                'type' => 'error'
            ];
        } else {
            // enkripsi password
            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $query = "INSERT INTO " . $this->table . " VALUES (:id, :nama, :username, :email, :reg_date, :coin, :password, :profile_pic, :phone_no)";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $this->db->bind(':nama', $data['name']);
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':reg_date', $reg_date);
            $this->db->bind(':coin', $coin);
            $this->db->bind(':password', $password);
            $this->db->bind(':profile_pic', $profile_pic);
            $this->db->bind(':phone_no', $data['phone']);
            $this->db->execute();

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Register successfully',
                'type' => 'success'
            ];

        }
        
    }
}
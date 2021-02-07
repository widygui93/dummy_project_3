<?php
class Signup_model extends Model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function signupStudent($data){
        $reg_date = $this->getDate();
        $coin = 100;
        $profile_pic = 'default.png';
        if( !$this->doesMandatoryDataFilled(array(
            "name" => $data['name'],
            "username" => $data['username'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "password" => $data['password'],
            "password-confirm" => $data['password-confirm']
        ) ) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data name, username, email, phone no, password and password confirm are mandatory'
            ];
        } elseif( $this->isUsernameExist($data['username'], 'student') ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Username already exist'
            ];
        } elseif( $this->isBreak($data['username'], "/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W]).{6,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Username Format: Combination of letters and numbers, Length: 6 - 12'
            ];

        } elseif( $this->isBreak($data['name'], "/^[a-zA-Z .,]*$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Name Format: letters, space, comma and period'
            ];
        } elseif( $this->isBreak($data['email'], "/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Email must follow this format: yourname@domain.com(.id)'
            ];
        } elseif( $this->isBreak($data['phone'], "/^\d{10,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Phone Format: number only, Length: 10 - 12 digit'
            ];
        } elseif( $this->isBreak($data['password'], "/^[\w@-]{8,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Password Allow letter, number, @, -, _ Length: 10 - 12 digit'
            ];
        } elseif( $this->isNotMatch($data['password'],$data['password-confirm']) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Password does not match with Confirm Password'
            ];
        } else {
            $data['name'] = $this->purify($data['name']);
            $data['username'] = $this->purify($data['username']);
            $data['email'] = $this->purify($data['email']);
            $data['phone'] = $this->purify($data['phone']);
            $data['password'] = $this->purify($data['password']);
            $data['password-confirm'] = $this->purify($data['password-confirm']);
            // enkripsi password
            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $student = R::dispense('student');
            $student->name = strtolower(stripslashes($data['name']));
            $student->username = strtolower(stripslashes($data['username']));
            $student->email = strtolower(stripslashes($data['email']));
            $student->reg_date = $reg_date;
            $student->coin = $coin;
            $student->password = $password;
            $student->profile_pic = $profile_pic;
            $student->phone_no = stripslashes($data['phone']);
            R::store($student);

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Register successfully'
            ];

        }
        
    }
    public function signupTeacher($data){
        $reg_date = $this->getDate();
        $coin = 0;
        $profile_pic = 'default.png';
        if( !$this->doesMandatoryDataFilled(array(
            "name" => $data['name'],
            "username" => $data['username'],
            "email" => $data['email'],
            "expert" => $data['expert'],
            "password" => $data['password'],
            "password-confirm" => $data['password-confirm']
        ) ) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data name, username, email, expert, password and password confirm are mandatory'
            ];
        } elseif( $this->isUsernameExist($data['username'], 'teacher') ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Username already exist'
            ];
        } elseif( $this->isBreak($data['username'], "/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W]).{6,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Username Format: Combination of letters and numbers, Length: 6 - 12'
            ];

        } elseif( $this->isBreak($data['name'], "/^[a-zA-Z .,]*$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Name Format: letters, space, comma and period'
            ];
        } elseif( $this->isBreak($data['email'], "/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Email must follow this format: yourname@domain.com(.id)'
            ];
        } elseif( $this->isBreak($data['expert'], "/^[a-zA-Z .,]*$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Expert Format: letters, space, comma and period'
            ];
        } elseif( $this->isBreak($data['password'], "/^[\w@-]{8,12}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Password Allow letter, number, @, -, _ Length: 10 - 12 digit'
            ];
        } elseif( $this->isNotMatch($data['password'],$data['password-confirm']) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Password does not match with Confirm Password'
            ];
        } else {
            $data['name'] = $this->purify($data['name']);
            $data['username'] = $this->purify($data['username']);
            $data['email'] = $this->purify($data['email']);
            $data['expert'] = $this->purify($data['expert']);
            $data['password'] = $this->purify($data['password']);
            $data['password-confirm'] = $this->purify($data['password-confirm']);
            // enkripsi password
            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $teacher = R::dispense('teacher');
            $teacher->name = strtolower(stripslashes($data['name']));
            $teacher->username = strtolower(stripslashes($data['username']));
            $teacher->email = strtolower(stripslashes($data['email']));
            $teacher->reg_date = $reg_date;
            $teacher->coin = $coin;
            $teacher->password = $password;
            $teacher->profile_pic = $profile_pic;
            $teacher->expert = strtolower(stripslashes($data['expert']));
            $teacher->expert = $data['expert'];
            R::store($teacher);

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Register successfully'
            ];

        }
        
    }
}
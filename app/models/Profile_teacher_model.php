<?php
class Profile_teacher_model extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getProfileInfoBy(string $username): array
    {
        if ($this->isBreak($username, "/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W]).{6,12}$/")) {
            return [];
        } else {
            $username = stripslashes($this->purify($username));

            $query = "
                SELECT name,
                        username,
                        email,
                        to_char(reg_date, 'Month DD,YYYY') AS reg_date,
                        profile_pic,
                        expert
                FROM teacher WHERE username = :username
            ";
            return R::getAll($query, [':username' => strtolower($username)]);
        }
    }

    public function changePassword(array $data): array
    {

        if ($this->isDataEmpty($data)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data must be sent'
            ];
        } elseif (!$this->doesMandatoryDataFilled(array(
            "old-password" => $data['old-password'],
            "new-password" => $data['new-password'],
            "password-confirm" => $data['password-confirm']
        ))) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data current password, new password and password confirm are mandatory'
            ];
        } elseif ($this->isBreak($data['old-password'], "/^[\w@-]{8,12}$/")) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Current Password Allow letter, number, @, -, _ Length: 8 - 12 digit'
            ];
        } elseif ($this->isBreak($data['new-password'], "/^[\w@-]{8,12}$/")) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'New Password Allow letter, number, @, -, _ Length: 8 - 12 digit'
            ];
        } elseif ($this->isOldPasswordInvalid($data['old-password'], $_SESSION["username_teacher"], "teacher")) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Invalid Current password'
            ];
        } elseif ($this->isNotMatch($data['new-password'], $data['password-confirm'])) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'New Password does not match with Confirm Password'
            ];
        } elseif ($this->isPasswordsSame($data['old-password'], $data['new-password'])) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Current password can not same with New password'
            ];
        } else {
            $newPassword = $this->purify($data['new-password']);

            // enkripsi password
            $newEncryptedPass = password_hash($newPassword, PASSWORD_DEFAULT);

            $teacherID = $this->getTeacherID();

            $updatedTeacher = R::load('teacher', $teacherID);
            $updatedTeacher->password = $this->purify($newEncryptedPass);

            try {
                if (R::store($updatedTeacher)) {
                    return [
                        'icon' => 'success',
                        'title' => 'Success',
                        'text' => 'Change password successfully'
                    ];
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Change password failed'
                ];
            }
        }
    }

    public function editProfilePic(array $data): array
    {
        if ($this->isDataEmpty($data)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data must be sent'
            ];
        } elseif (!$this->doesMandatoryDataFilled(array(
            "profile-pic" => $_FILES['profile-pic']['name']
        ))) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Image profile picture is mandatory'
            ];
        } elseif ($this->isViolateMaxSize($_FILES['profile-pic']['size'], 200000)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Max profile picture size is 200 KB'
            ];
        } elseif ($this->isViolateFileExtention($_FILES['profile-pic']['name'], ['jpg', 'jpeg', 'png'])) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'You upload incorrect image extention'
            ];
        } else {
            try {
                $profilePic = $this->upload("../app/core/profile-picture/teacher/", $_FILES['profile-pic']['tmp_name'], $_FILES['profile-pic']['name']);
            } catch (Exception $e) {
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => $e->getMessage()
                ];
            }

            $teacherID = $this->getTeacherID();

            $updatedTeacher = R::load('teacher', $teacherID);
            $updatedTeacher->profile_pic = $this->purify($profilePic);

            try {
                if (R::store($updatedTeacher)) {
                    return [
                        'icon' => 'success',
                        'title' => 'Success',
                        'text' => 'Edit profile picture successfully'
                    ];
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Edit profile picture failed'
                ];
            }
        }
    }

    private function getTeacherID(): string
    {
        $query = "SELECT id FROM teacher WHERE username = :username";
        $teacher = R::getAll($query, [':username' => strtolower($_SESSION["username_teacher"])]);
        return $teacher[0]['id'];
    }
}

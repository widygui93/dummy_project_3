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
}

<?php

class Model {
    private $db;
    public function createRandomID(): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomID = '';

        for($i = 0; $i < 30; $i++){
            $index = rand(0, strlen($characters) - 1);
            $randomID = $randomID . substr($characters,$index,1);
        }

        return $randomID;

    }
    
    public function getRegisterDate(): string {
        return date("Y-m-d",strtotime(date("Y-m-d")));
    }

    public function doesMandatoryDataFilled(array $data): bool {
        foreach ($data as $val){
            if( strlen($val) == 0 ){
                return false;
                break;
            }
        }
        return true;
    }

    public function purify($data){
        return htmlspecialchars($data);
    }

    public function isUsernameExist(string $username, string $table): bool{
        $this->db = new Database;
        $query = "SELECT * FROM  " . $table . " WHERE username = '" . $username . "'";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->rowCount() > 0 ? true : false;
    }

    public function isBreak(string $data, string $pattern): bool{
        return preg_match($pattern, $data) === 1 ?  false :  true;
    }

}
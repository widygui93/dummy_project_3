<?php
class Home_model extends Model{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getTutorials(): array{
        return $this->getTutorialsFromModelClass();
    }

    public function getTotalTutorials():int{
        return $this->getTotalTutorialsFromModelClass();

    }

}
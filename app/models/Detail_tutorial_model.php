<?php
class Detail_tutorial_model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getDetailTutorialBy(string $id):array {
        $detailTutorial = $this->getDetail($id);
        $totalPurchased = $this->getTotalPurchased($id);
        $totalLiked = $this->getTotalLiked($id);

        $detailTutorial['total_purchased'] = $totalPurchased['total_purchased'];
        $detailTutorial['total_like'] = $totalLiked['total_like'];

        return $detailTutorial;

    }

    private function getDetail(string $id): array{
        $query = 
            "SELECT title, 
                img_cover,
                created_by,
                to_char(prize, '999,999,999') AS prize,
                to_char(created_date, 'Month DD,YYYY') AS created_date,
                level,
                video_duration,
                subtitle,
                tutorial.desc AS description 
            FROM tutorial WHERE id = :id
        ";
        return $this->retrieveData($query,$id);
    }

    private function getTotalPurchased(string $id): array{
        $query = "SELECT COUNT(id) AS total_purchased FROM purchased_tutorial WHERE id_tutorial = :id";
        return $this->retrieveData($query,$id);
    }

    private function getTotalLiked(string $id): array {
        $query = "SELECT COUNT(id) AS total_like FROM liked_tutorial WHERE id_tutorial = :id";
        return $this->retrieveData($query,$id);
    }

    private function retrieveData(string $queryStmt, string $id): array{
        $this->db->query($queryStmt);
        $this->db->bind(':id', $id);
        return $retrieveData = $this->db->single();
    }

}
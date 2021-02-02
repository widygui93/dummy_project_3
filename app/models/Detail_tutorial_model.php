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
        $tags = $this->getTags($detailTutorial['tutorial_date'], $totalPurchased['total_purchased'], $totalLiked['total_like']);

        $detailTutorial['total_purchased'] = $totalPurchased['total_purchased'];
        $detailTutorial['total_like'] = $totalLiked['total_like'];
        $detailTutorial['tags'] = $tags;

        return $detailTutorial;

    }

    private function getDetail(string $id): array{
        $query = 
            "SELECT title, 
                img_cover,
                created_by,
                to_char(prize, '999,999,999') AS prize,
                to_char(created_date, 'Month DD,YYYY') AS created_date,
                created_date AS tutorial_date,
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

    private function getTags(string $tutorialDate, int $totalPurchased, int $totalLiked): array{
        $possibleTags = [];

        $createdTutorialTimestamp = strtotime($tutorialDate);
        $currentTimestamp = strtotime(date("Y-m-d H:i:s"));
        $selisihDalamTimestamp = $currentTimestamp - $createdTutorialTimestamp;
        // ubah detik ke hari
        $selisihDalamHari = $selisihDalamTimestamp / 86400;
        
        if( $selisihDalamHari < 2 ) $possibleTags[] = 'latest tutorial';
        if( $totalPurchased > 0 ) $possibleTags[] = 'best seller';
        if( $totalLiked > 0 ) $possibleTags[] = 'most liked';

        return $possibleTags;

    }

    private function retrieveData(string $queryStmt, string $id): array{
        $this->db->query($queryStmt);
        $this->db->bind(':id', $id);
        return $retrieveData = $this->db->single();
    }

}
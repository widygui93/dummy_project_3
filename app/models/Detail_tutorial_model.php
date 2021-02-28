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
        $tags = $this->getTags($detailTutorial[0]['tutorial_date'], $totalPurchased, $totalLiked);

        $detailTutorial[0]['total_purchased'] = $totalPurchased;
        $detailTutorial[0]['total_like'] = $totalLiked;
        $detailTutorial[0]['tags'] = $tags;

        return $detailTutorial;

    }

    private function getDetail(int $id): array{

        $query = "
            SELECT title,
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
        return R::getAll( $query, [ ':id' => $id ] );
        
    }

    private function getTotalPurchased(string $id): int{
        return R::count( 'purchased_tutorial', ' tutorial_id = :id ', [ ':id' => $id ] );
    }

    private function getTotalLiked(string $id): int {
        return R::count( 'liked_tutorial', ' tutorial_id = :id ', [ ':id' => $id ] );
    }

    private function getTags(string $tutorialDate, int $totalPurchased, int $totalLiked): array{
        $possibleTags = [];

        $createdTutorialTimestamp = strtotime($tutorialDate);
        $currentTimestamp = strtotime(date("Y-m-d H:i:s"));
        $selisihDalamTimestamp = $currentTimestamp - $createdTutorialTimestamp;
        // ubah detik ke hari
        $selisihDalamHari = $selisihDalamTimestamp / 86400;
        
        if( $selisihDalamHari < 1 ) $possibleTags[] = 'Latest Tutorial';
        if( $totalPurchased > 0 ) $possibleTags[] = 'Best Seller';
        if( $totalLiked > 0 ) $possibleTags[] = 'Most Liked';

        return $possibleTags;

    }

}
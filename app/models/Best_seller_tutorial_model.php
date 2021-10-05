<?php
class Best_seller_tutorial_model extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getBestSellerTutorials(): array
    {
        $numOfTutorials = R::count('tutorial');
        if ($numOfTutorials > 0) {
            $query = "
                SELECT 
                    COUNT(id_like_tutorial) AS total_like,
                    COUNT(id_purchase_tutorial) AS total_purchase,
                    title,
                    id,
                    img_cover,
                    created_by,
                    prize,
                    created_date,
                    tutorial_date
                FROM (
                    SELECT tutorial.title,
                            tutorial.id,
                            tutorial.img_cover,
                            tutorial.created_by,
                            to_char(tutorial.prize, '999,999,999') AS prize,
                            to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                            tutorial.created_date AS tutorial_date,
                            liked_tutorial.id as id_like_tutorial, 
                            purchased_tutorial.id as id_purchase_tutorial
                    FROM tutorial
                    FULL OUTER JOIN liked_tutorial ON tutorial.id=liked_tutorial.tutorial_id
                    FULL OUTER JOIN purchased_tutorial ON tutorial.id = purchased_tutorial.tutorial_id
                    WHERE tutorial.is_revoke = 'N'
                ) AS tbl_tutorial
                GROUP BY title,
                id,
                img_cover,
                created_by,
                prize,
                created_date,
                tutorial_date
                ORDER BY total_purchase DESC , tutorial_date DESC
                LIMIT " . TUTORIALS_PER_PAGE . "
            ";

            $tutorials = R::getAll($query);

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
        } else {
            $tutorials = array();
            return $tutorials;
        }
    }
}

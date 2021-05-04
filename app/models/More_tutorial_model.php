<?php
class More_tutorial_model extends Model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getMoreTutorial(string $username, int $startIndexOfMoreTutorials): array{
        $tutorialsPerPage = 4;
        $numOfTutorials = R::count( 'tutorial', ' created_by = ? ', [ $username ] );
        if( $numOfTutorials > 0 ){
            $query = "
                SELECT COUNT(id) AS total_like, id, title, img_cover, created_by, prize, created_date, tutorial_date
                FROM (
                    SELECT tutorial.id,
                        tutorial.title,
                        tutorial.img_cover,
                        tutorial.created_by,
                        to_char(tutorial.prize, '999,999,999') AS prize,
                        to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                        tutorial.created_date AS tutorial_date,
                        liked_tutorial.liked_by
                    FROM tutorial JOIN liked_tutorial ON tutorial.id = liked_tutorial.tutorial_id
                    WHERE tutorial.created_by = '" . $username . "'
                ) AS tbl_tutorial
                GROUP BY id,title, img_cover, created_by , prize,created_date, tutorial_date
                UNION
                SELECT 0 AS total_like,id, title, img_cover, created_by , prize,created_date, tutorial_date
                    FROM (
                        SELECT tutorial.id,
                            tutorial.title,
                            tutorial.img_cover,
                            tutorial.created_by,
                            to_char(tutorial.prize, '999,999,999') AS prize,
                            to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                            tutorial.created_date AS tutorial_date,
                            liked_tutorial.liked_by
                        FROM tutorial LEFT JOIN liked_tutorial ON tutorial.id = liked_tutorial.tutorial_id
                        WHERE tutorial.created_by = '" . $username . "' AND liked_by IS NULL
                    ) AS tbl_tutorial
                ORDER BY tutorial_date DESC
                LIMIT " . $tutorialsPerPage . " OFFSET " . $startIndexOfMoreTutorials . "
            ";

            $tutorials = R::getAll( $query );

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
            

        } else {
            $tutorials = array();
            return $tutorials;
        }

    }
}
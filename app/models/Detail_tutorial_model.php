<?php
class Detail_tutorial_model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getDetailTutorialBy(string $id):array {
        $query = "
        SELECT COUNT(id) AS total_like, id, title, img_cover, created_by, prize, created_date, level, video_duration, subtitle, description
                FROM (
                    SELECT tutorial.id,
                        tutorial.title,
                        tutorial.img_cover,
                        tutorial.created_by,
                        to_char(tutorial.prize, '999,999,999') AS prize,
                        to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
						tutorial.level,
						tutorial.desc AS description,
						tutorial.video_duration,
						tutorial.subtitle,
                        liked_tutorial.liked_by
                    FROM tutorial JOIN liked_tutorial ON tutorial.id = liked_tutorial.id_tutorial
                    WHERE tutorial.id = :id
                ) AS tbl_tutorial
            GROUP BY id,title, img_cover, created_by , prize,created_date, level, video_duration, subtitle, description
            UNION
            SELECT 0 AS total_like,id, title, img_cover, created_by , prize,created_date, level, video_duration, subtitle, description
                FROM (
                    SELECT tutorial.id,
                        tutorial.title,
                        tutorial.img_cover,
                        tutorial.created_by,
                        to_char(tutorial.prize, '999,999,999') AS prize,
                        to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
						tutorial.level,
						tutorial.desc AS description,
						tutorial.video_duration,
						tutorial.subtitle,
                        liked_tutorial.liked_by
                    FROM tutorial LEFT JOIN liked_tutorial ON tutorial.id = liked_tutorial.id_tutorial
                    WHERE tutorial.id = :id AND liked_by IS NULL
                ) AS tbl_tutorial
            ORDER BY created_date DESC
        ";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $detailTutorial = $this->db->single();

        return $detailTutorial;

    }

}
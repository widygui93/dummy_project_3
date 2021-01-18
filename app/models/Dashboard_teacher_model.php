<?php
class Dashboard_teacher_model extends Model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function createTutorial($data){
        if( !$this->doesMandatoryDataFilled(array(
            "title" => $data['title'],
            "level" => $data['level'],
            "prize" => $data['prize'],
            "desc" => $data['desc'],
            "video" => $_FILES['video']['name'],
            "img-cover" => $_FILES['img-cover']['name']
        ) ) ) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data title, level, prize, desc, video and img-cover are mandatory'
            ];
        } elseif( $this->isViolateMaxSize($_FILES['video']['size'], 200000) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Max video size is 200 KB'
            ];
        } elseif( $this->isViolateMaxSize($_FILES['img-cover']['size'], 200000) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Max image size is 200 KB'
            ];

        } elseif( $this->isViolateFileExtention($_FILES['img-cover']['name'], ['jpg', 'jpeg', 'png']) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'You upload incorrect image extention'
            ];

        } elseif( $this->isViolateFileExtention($_FILES['video']['name'], ['webm', 'mp4']) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'You upload incorrect video extention'
            ];

        } elseif( $this->isBreak($data['title'], "/^[a-zA-Z0-9 .,\-&]{6,50}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Title Format: Combination of letters and numbers, Length: 6 - 50'
            ];
        } elseif( $this->isBreak($data['level'], "/^[a-zA-Z_]*$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Level Format: letters only'
            ];
        } elseif( $this->isBreak($data['prize'], "/^[0-9]*$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Prize Format: number only'
            ];
        } elseif( $this->isBreak($data['desc'], "/^[\w -.,!?\n\t\r]{10,300}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Desc Format: Combination of letters and numbers, Length: 10 - 300 characters'
            ];
        }
        else {
            $createdDate = $this->getDate();
            $id = $this->createRandomID();
            $createdBy = $_SESSION["username-teacher"];
            $videoDuration = $this->getVideoDuration($_FILES['video']['tmp_name']);

            $data['title'] = $this->purify($data['title']);
            $data['level'] = $this->purify($data['level']);
            $data['prize'] = $this->purify($data['prize']);
            $data['desc'] = $this->purify($data['desc']);

            $imgCover = $this->upload("../app/core/videos/cover-img/", $_FILES['img-cover']['tmp_name'], $_FILES['img-cover']['name']);
            if( !$imgCover ){
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Failed to upload image cover'
                ];
            }

            $video = $this->upload("../app/core/videos/", $_FILES['video']['tmp_name'], $_FILES['video']['name']);
            if( !$video ){
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Failed to upload video'
                ];
            }

            $query = "INSERT INTO tutorial VALUES (:id, :title, :createdBy, :prize, :createdDate, :level, :desc, :video, :imgCover, :videoDuration)";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $this->db->bind(':title', stripslashes($data['title']));
            $this->db->bind(':createdBy', $createdBy);
            $this->db->bind(':prize', stripslashes($data['prize']));
            $this->db->bind(':createdDate', $createdDate);
            $this->db->bind(':level', stripslashes($data['level']));
            $this->db->bind(':desc', stripslashes($data['desc']));
            $this->db->bind(':video', $video);
            $this->db->bind(':imgCover', $imgCover);
            $this->db->bind(':videoDuration', $videoDuration);
            $this->db->execute();

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Create Tutorial successfully'
            ];
        }
    }

    public function getTutorialsBy(string $username): array{
        $query = "
            SELECT COUNT(id) AS total_like, id, title, img_cover, created_by, prize, created_date
                FROM (
                    SELECT tutorial.id,
                        tutorial.title,
                        tutorial.img_cover,
                        tutorial.created_by,
                        to_char(tutorial.prize, '999,999,999') AS prize,
                        to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                        liked_tutorial.liked_by
                    FROM tutorial JOIN liked_tutorial ON tutorial.id = liked_tutorial.id_tutorial
                    WHERE tutorial.created_by = :username
                ) AS tbl_tutorial
            GROUP BY id,title, img_cover, created_by , prize,created_date
            UNION
            SELECT 0 AS total_like,id, title, img_cover, created_by , prize,created_date
                FROM (
                    SELECT tutorial.id,
                        tutorial.title,
                        tutorial.img_cover,
                        tutorial.created_by,
                        to_char(tutorial.prize, '999,999,999') AS prize,
                        to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                        liked_tutorial.liked_by
                    FROM tutorial LEFT JOIN liked_tutorial ON tutorial.id = liked_tutorial.id_tutorial
                    WHERE tutorial.created_by = :username AND liked_by IS NULL
                ) AS tbl_tutorial
            ORDER BY created_date DESC
        ";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $resultSets = $this->db->resultSet();

        $resultSets = $this->shortenTitle($resultSets);

        return $resultSets;

    }
}
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
        } elseif( $this->isBreak($data['prize'], "/^[0-9]*$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Prize Format: number only'
            ];
        } elseif( $this->isBreak($data['desc'], "/^[\w -.,'!?\n\t\r]{10,300}$/") ){
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

            $data['title'] = $this->purify($data['title']);
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

            $query = "INSERT INTO tutorial VALUES (:id, :title, :createdBy, :prize, :createdDate, :level, :desc, :video, :imgCover)";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $this->db->bind(':title', strtolower(stripslashes($data['title'])));
            $this->db->bind(':createdBy', $createdBy);
            $this->db->bind(':prize', strtolower(stripslashes($data['prize'])));
            $this->db->bind(':createdDate', $createdDate);
            $this->db->bind(':level', strtolower(stripslashes($data['level'])));
            $this->db->bind(':desc', strtolower(stripslashes($data['desc'])));
            $this->db->bind(':video', $video);
            $this->db->bind(':imgCover', $imgCover);
            $this->db->execute();

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Create Tutorial successfully'
            ];
        }
    }
}
<?php
class Dashboard_teacher_model extends Model {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function createTutorial($data){
        if( $this->isDataEmpty($data) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data must be sent'
            ];
        } elseif( !$this->doesMandatoryDataFilled(array(
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

        } elseif( $this->isViolateMaxSize($_FILES['subtitle']['size'], 200000) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Max file subtitle size is 200 KB'
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

        } elseif( $this->isViolateFileExtention($_FILES['subtitle']['name'], ['vtt', '']) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'You upload incorrect subtitle extention'
            ];

        } elseif( $this->isBreak($data['title'], "/^[a-zA-Z0-9 .,\-&]{6,50}$/") ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Title Format: Combination of letters and numbers, Length: 6 - 50'
            ];
        } elseif( $this->isBreak($data['level'], "/^[a-zA-Z ]*$/") ){
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
            $createdBy = $_SESSION["username_teacher"];
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

            $subtitle = null;
            if( $_FILES['subtitle']['error'] !== 4 ){
                $subtitle = $this->upload("../app/core/videos/subtitles/", $_FILES['subtitle']['tmp_name'], $_FILES['subtitle']['name']);
                if( !$subtitle ){
                    return [
                        'icon' => 'error',
                        'title' => 'Failed',
                        'text' => 'Failed to upload subtitle'
                    ];
                }
            }

            $video = $this->upload("../app/core/videos/", $_FILES['video']['tmp_name'], $_FILES['video']['name']);
            if( !$video ){
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Failed to upload video'
                ];
            }

            $tutorial = R::dispense( 'tutorial' );
            $tutorial->title = stripslashes($data['title']);
            $tutorial->created_by = $createdBy;
            $tutorial->prize = stripslashes($data['prize']);
            $tutorial->created_date = $createdDate;
            $tutorial->level = stripslashes($data['level']);
            $tutorial->description = stripslashes($data['desc']);
            $tutorial->video = $video;
            $tutorial->img_cover = $imgCover;
            $tutorial->video_duration = $videoDuration;
            $tutorial->subtitle = $subtitle;
            $tutorial->is_revoke = 'N';
            R::store($tutorial);

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Create Tutorial successfully'
            ];
        }
    }


    private function isViolateMaxSize(int $fileSize, int $maxSize): bool{
        return $fileSize > $maxSize ? true : false;
    }

    private function isViolateFileExtention(string $namaFile, array $validExtention): bool{
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        return in_array($ekstensiGambar, $validExtention) ? false : true;
    }

    private function getVideoDuration($vidTmpName){
        $ffmpeg = 'ffmpeg -i ' . $vidTmpName . ' -vstats 2>&1';
        $output = shell_exec($ffmpeg);
        $regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
        if (preg_match($regex_duration, $output, $regs)) {
            $hours = $regs [1] ? $regs [1] : null;
            $mins = $regs [2] ? $regs [2] : null;
            $secs = $regs [3] ? $regs [3] : null;
        }
        $video_duration = $hours . ':' . $mins . ':' . $secs;
        return $video_duration;
    }

    private function upload($folder, $tmpName, $namaFile){
        $ekstensiGambar = explode('.', $namaFile);
		$ekstensiGambar = strtolower(end($ekstensiGambar));
		// generate nama gambar baru
		$namaFileBaru = $this->createRandomString();
		$namaFileBaru .= '.';
		$namaFileBaru .= $ekstensiGambar;

		move_uploaded_file($tmpName, $folder . $namaFileBaru);

		return $namaFileBaru;

    }

    public function getTutorialsBy(string $username): array{
        $tutorialsPerPage = 4;
        $numOfTutorials = R::count( 'tutorial', ' created_by = ? ', [ $username ] );
        if( $numOfTutorials > 0 ){
            $query = "
                SELECT COUNT(id) AS total_like, id, title, img_cover, created_by, prize, created_date, tutorial_date, is_revoke
                FROM (
                    SELECT tutorial.id,
                        tutorial.title,
                        tutorial.img_cover,
                        tutorial.created_by,
                        to_char(tutorial.prize, '999,999,999') AS prize,
                        to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                        tutorial.created_date AS tutorial_date,
                        tutorial.is_revoke,
                        liked_tutorial.liked_by
                    FROM tutorial JOIN liked_tutorial ON tutorial.id = liked_tutorial.tutorial_id
                    WHERE tutorial.created_by = '" . $username . "'
                ) AS tbl_tutorial
                GROUP BY id,title, img_cover, created_by , prize,created_date, tutorial_date, is_revoke
                UNION
                SELECT 0 AS total_like,id, title, img_cover, created_by , prize,created_date, tutorial_date, is_revoke
                    FROM (
                        SELECT tutorial.id,
                            tutorial.title,
                            tutorial.img_cover,
                            tutorial.created_by,
                            to_char(tutorial.prize, '999,999,999') AS prize,
                            to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                            tutorial.created_date AS tutorial_date,
                            tutorial.is_revoke,
                            liked_tutorial.liked_by
                        FROM tutorial LEFT JOIN liked_tutorial ON tutorial.id = liked_tutorial.tutorial_id
                        WHERE tutorial.created_by = '" . $username . "' AND liked_by IS NULL
                    ) AS tbl_tutorial
                ORDER BY tutorial_date DESC
                LIMIT " . $tutorialsPerPage . "
            ";

            $tutorials = R::getAll( $query );

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
            

        } else {
            $tutorials = array();
            return $tutorials;
        }

    }

    public function getTotalTutorialsBy(string $username):int{
        return R::count( 'tutorial', ' created_by = ? ', [ $username ] );

    }

    public function revokeTutorial(string $id){
        if( $this->isIDNotUUID($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'ID is invalid data type'
            ];
        } elseif( $this->isIdNotAvailable($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not available'
            ];
        } elseif( $this->isIneligibleTutorial($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not authorized to access'
            ];
        } elseif( $this->isAlreadyRevoke($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial has already been revoked'
            ];
        } else {
            $revokedTutorial = R::load('tutorial', $id);
            $revokedTutorial->is_revoke = 'Y';
            R::store($revokedTutorial);

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Revoke Tutorial successfully'
            ];
        }
    }

    public function restoreTutorial(string $id){
        if( $this->isIDNotUUID($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'ID is invalid data type'
            ];
        } elseif( $this->isIdNotAvailable($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not available'
            ];
        } elseif( $this->isIneligibleTutorial($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not authorized to access'
            ];
        } elseif( $this->isAlreadyRestore($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial has already been restore'
            ];
        } else {
            $restoredTutorial = R::load('tutorial', $id);
            $restoredTutorial->is_revoke = 'N';
            R::store($restoredTutorial);

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Restore Tutorial successfully'
            ];
        }
    }

    private function isAlreadyRevoke(string $id): bool{
        $revokedTutorial = R::load('tutorial', $id);
        return $revokedTutorial->is_revoke == 'Y' ? true : false;
    }

    private function isAlreadyRestore(string $id): bool{
        $restoredTutorial = R::load('tutorial', $id);
        return $restoredTutorial->is_revoke == 'N' ? true : false;
    }

    public function getDataTutorialToDisplayBeforeUpdate(string $id): array{
        if( $this->isIDNotUUID($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'ID is invalid data type'
            ];
        } elseif( $this->isIdNotAvailable($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not available'
            ];
        } elseif( $this->isIneligibleTutorial($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not authorized to access'
            ];
        } else {

            $query = "
                SELECT  prize,
                        description 
                FROM tutorial WHERE id = :id
            ";

            $DataTutorialToDisplayBeforeUpdate = R::getAll( $query, [ ':id' => $id ] );

            return [
                'icon' => 'info',
                'title' => 'Update This Tutorial',
                'dataTutorial' => $DataTutorialToDisplayBeforeUpdate
            ];

        }

    }
    
    public function updateTutorial(string $id, string $prize, string $desc): array {
        if( $this->isIDNotUUID($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'ID is invalid data type'
            ];
        } elseif( $this->isIdNotAvailable($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not available'
            ];
        } elseif( $this->isIneligibleTutorial($id) ){
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not authorized to access'
            ];
        } else {
            $updatedTutorial = R::load('tutorial', $id);
            $updatedTutorial->prize = $prize;
            $updatedTutorial->description = $desc;
            R::store($updatedTutorial);

            return [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Update Tutorial successfully'
            ];
        }
    }
}
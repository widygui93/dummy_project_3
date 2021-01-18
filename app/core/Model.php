<?php

class Model {
    private $db;
    public function createRandomID(): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomID = '';

        for($i = 0; $i < 30; $i++){
            $index = rand(0, strlen($characters) - 1);
            $randomID = $randomID . substr($characters,$index,1);
        }

        return $randomID;

    }
    
    public function getDate(): string {
        return date("Y-m-d",strtotime(date("Y-m-d")));
    }

    /*untuk cek jika user langsung ketik 
     http://localhost/widy/project/dummy_project_3/public/login/teacher 
     tanpa klik login */
    // public function isDataEmpty(array $data): bool {
    //     return empty($data) ? true : false;
    // }

    public function doesMandatoryDataFilled(array $data): bool {
        foreach ($data as $val){
            if( strlen($val) == 0 ){
                return false;
                break;
            }
        }
        return true;
    }

    public function purify($data){
        return htmlspecialchars($data);
    }

    public function isUsernameExist(string $username, string $table): bool{
        $this->db = new Database;
        $query = "SELECT * FROM  " . $table . " WHERE username = '" . strtolower(stripslashes($username)) . "'";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->rowCount() > 0 ? true : false;
    }

    public function isBreak(string $data, string $pattern): bool{
        return preg_match($pattern, $data) === 1 ?  false :  true;
    }

    public function isNotMatch(string $password, string $password_confirm): bool{
        return $password !== $password_confirm ? true : false;
    }

    public function isViolateMaxSize(int $fileSize, int $maxSize): bool{
        return $fileSize > $maxSize ? true : false;
    }

    public function isViolateFileExtention(string $namaFile, array $validExtention): bool{
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        return in_array($ekstensiGambar, $validExtention) ? false : true;
    }

    public function upload($folder, $tmpName, $namaFile){
        $ekstensiGambar = explode('.', $namaFile);
		$ekstensiGambar = strtolower(end($ekstensiGambar));
		// generate nama gambar baru
		$namaFileBaru = $this->createRandomID();
		$namaFileBaru .= '.';
		$namaFileBaru .= $ekstensiGambar;

		move_uploaded_file($tmpName, $folder . $namaFileBaru);

		return $namaFileBaru;

    }

    public function getVideoDuration($vidTmpName){
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

    public function shortenTitle(array $tutorialSets): array{
        foreach($tutorialSets as &$tutorialSet ){
            if( strlen($tutorialSet['title']) > 23 ){
                $tutorialSet['title'] = substr($tutorialSet['title'], 0, 20);
                $tutorialSet['title'] = $tutorialSet['title'] . '...';
            }
        }
        unset($tutorialSet);
        return $tutorialSets;
    }

}
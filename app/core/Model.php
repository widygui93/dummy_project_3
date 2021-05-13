<?php

class Model {
    private $db;
    public function createRandomString(): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomID = '';

        for($i = 0; $i < 30; $i++){
            $index = rand(0, strlen($characters) - 1);
            $randomID = $randomID . substr($characters,$index,1);
        }

        return $randomID;

    }
    
    public function getDate(): string {
        return date("Y-m-d H:i:s");
    }

    /*untuk cek jika user langsung ketik 
     http://localhost/widy/project/dummy_project_3/public/login/teacher 
     tanpa klik login */
    // public function isDataEmpty(array $data): bool {
    //     return empty($data) ? true : false;
    // }

    public function isDataEmpty(array $data): bool{
        return empty($data) ? true : false;
    }

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
        $numOfUser = R::count( $table, ' username = ? ' , [ $username ] );
        return $numOfUser > 0 ? true : false;
    }

    public function isBreak(string $data, string $pattern): bool{
        return preg_match($pattern, $data) === 1 ?  false :  true;
    }

    public function isNotMatch(string $password, string $password_confirm): bool{
        return $password !== $password_confirm ? true : false;
    }

    public function isIdNotAvailable(string $id): bool{
        return R::count( 'tutorial', ' id = :id ', [ ':id' => $id ] ) > 0  ? false : true;
    }

    public function isIDNotUUID(string $id): bool{
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $id) === 1 ? false : true;
    }

    public function isIneligibleTutorial(string $id): bool {
        $tutorials = R::find( 'tutorial', ' id = :id and created_by = :created_by ', [ ':id' => $id, ':created_by' => $_SESSION["username_teacher"] ]);
        return empty($tutorials) ? true : false;
    }


    public function shortenTitle(array $tutorialSets): array{
        $maxChars = 23; // max jumlah karakter yang di tampilkan di browser
        $charLimit = 20; // batas karakter sebelum ...
        foreach($tutorialSets as &$tutorialSet ){
            if( strlen($tutorialSet['title']) > $maxChars ){
                $tutorialSet['title'] = substr($tutorialSet['title'], 0, $charLimit);
                $tutorialSet['title'] = $tutorialSet['title'] . '...';
            }
        }
        unset($tutorialSet);
        return $tutorialSets;
    }

}
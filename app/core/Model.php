<?php

class Model
{
    private $db;
    public function createRandomString(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomID = '';

        for ($i = 0; $i < 30; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomID = $randomID . substr($characters, $index, 1);
        }

        return $randomID;
    }

    public function getDate(): string
    {
        return date("Y-m-d H:i:s");
    }

    /*untuk cek jika user langsung ketik 
     http://localhost/widy/project/dummy_project_3/public/login/teacher 
     tanpa klik login */
    // public function isDataEmpty(array $data): bool {
    //     return empty($data) ? true : false;
    // }

    public function isDataEmpty(array $data): bool
    {
        return empty($data) ? true : false;
    }

    public function doesMandatoryDataFilled(array $data): bool
    {
        foreach ($data as $val) {
            if (strlen($val) == 0) {
                return false;
                break;
            }
        }
        return true;
    }

    public function purify($data)
    {
        return htmlspecialchars($data);
    }

    public function isUsernameExist(string $username, string $table): bool
    {
        $numOfUser = R::count($table, ' username = ? ', [$username]);
        return $numOfUser > 0 ? true : false;
    }

    public function isBreak(string $data, string $pattern): bool
    {
        return preg_match($pattern, $data) === 1 ?  false :  true;
    }

    public function isNotMatch(string $password, string $password_confirm): bool
    {
        return $password !== $password_confirm ? true : false;
    }

    public function isIdNotAvailable(string $id): bool
    {
        return R::count('tutorial', ' id = :id ', [':id' => $id]) > 0  ? false : true;
    }

    public function isIDNotUUID(string $id): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $id) === 1 ? false : true;
    }

    public function isIneligibleTutorial(string $id): bool
    {
        if (!isset($_SESSION["login_teacher"]) && !isset($_SESSION["login_student"])) {
            return false;
        }
        $tutorials = R::find('tutorial', ' id = :id and created_by = :created_by ', [':id' => $id, ':created_by' => $_SESSION["username_teacher"]]);
        return empty($tutorials) ? true : false;
    }


    public function shortenTitle(array $tutorialSets): array
    {
        $maxChars = 23; // max jumlah karakter yang di tampilkan di browser
        $charLimit = 20; // batas karakter sebelum ...
        foreach ($tutorialSets as &$tutorialSet) {
            if (strlen($tutorialSet['title']) > $maxChars) {
                $tutorialSet['title'] = substr($tutorialSet['title'], 0, $charLimit);
                $tutorialSet['title'] = $tutorialSet['title'] . '...';
            }
        }
        unset($tutorialSet);
        return $tutorialSets;
    }

    public function getTutorialsFromModelClass(): array
    {
        $numOfTutorials = R::count('tutorial');
        if ($numOfTutorials > 0) {
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
                    WHERE tutorial.is_revoke = 'N'
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
                        WHERE tutorial.is_revoke = 'N' AND liked_by IS NULL
                    ) AS tbl_tutorial
                ORDER BY tutorial_date DESC
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

    public function getTotalTutorialsFromModelClass(): int
    {
        return R::count("tutorial", " is_revoke = 'N' ");
    }

    public function getMoreTutorialsFromModelClass(int $startIndexOfMoreTutorials): array
    {
        $numOfTutorials = R::count('tutorial');
        if ($numOfTutorials > 0) {
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
                    WHERE tutorial.is_revoke = 'N'
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
                        WHERE tutorial.is_revoke = 'N' AND liked_by IS NULL
                    ) AS tbl_tutorial
                ORDER BY tutorial_date DESC
                LIMIT :tutorialsPerPage OFFSET :startIndexOfMoreTutorials
            ";

            $tutorials = R::getAll($query, [':tutorialsPerPage' => TUTORIALS_PER_PAGE, ':startIndexOfMoreTutorials' => $startIndexOfMoreTutorials]);

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
        } else {
            $tutorials = array();
            return $tutorials;
        }
    }

    public function searchWithLevenshteinDistance(string $keyword): array
    {
        $dataSources = strtolower($keyword);
        $dataTargets = array();
        $dataTargets = R::getAll('SELECT LOWER(title) AS title, id FROM tutorial WHERE is_revoke = ? ', ["N"]);

        $dataSourcesInArray = str_split($dataSources);
        $listLevenshteinDistances = array();

        foreach ($dataTargets as $targets) {

            $dataTargetsInArray = str_split($targets['title']);

            $map = array();
            for ($s = 0; $s < count($dataSourcesInArray) + 1; $s++) {
                $map[$s][0] = $s;
            }

            for ($t = 0; $t < count($dataTargetsInArray) + 1; $t++) {
                $map[0][$t] = $t;
            }

            $idxSource = 1;
            $idxTarget = 1;

            foreach ($dataSourcesInArray as $valueSource) {
                foreach ($dataTargetsInArray as $valueTarget) {
                    if ($valueSource == $valueTarget) {

                        $map[$idxSource][$idxTarget] = (0 + (min($map[$idxSource - 1][$idxTarget - 1], $map[$idxSource][$idxTarget - 1], $map[$idxSource - 1][$idxTarget])));
                    } else {

                        $map[$idxSource][$idxTarget] = (1 + (min($map[$idxSource - 1][$idxTarget - 1], $map[$idxSource][$idxTarget - 1], $map[$idxSource - 1][$idxTarget])));
                    }
                    $idxTarget = $idxTarget + 1;
                }
                $idxSource = $idxSource + 1;
                $idxTarget = 1;
            }

            array_push(
                $listLevenshteinDistances,
                array(
                    'id' => $targets['id'],
                    'title' => $targets['title'],
                    'Levenshtein_distance' => $map[count($dataSourcesInArray)][count($dataTargetsInArray)]
                )
            );
        }

        array_multisort(array_column($listLevenshteinDistances, 'Levenshtein_distance'), SORT_ASC, $listLevenshteinDistances);

        return $listLevenshteinDistances;
    }

    public function isOldPasswordInvalid(string $oldPassword, string $userName): bool
    {
        $query = "SELECT password FROM teacher WHERE username = :username";
        $data = R::getAll($query, [':username' => strtolower($userName)]);

        // cek username ada di db atau tidak
        if (empty($data)) return true;
        // cek password sama atau tidak
        return password_verify($oldPassword, $data[0]["password"]) ? false : true;
    }

    public function isPasswordsSame(string $oldPassword, string $newPassword): bool
    {
        return ($oldPassword === $newPassword) ? true : false;
    }

    public function isViolateMaxSize(int $fileSize, int $maxSize): bool
    {
        return $fileSize > $maxSize ? true : false;
    }

    public function isViolateFileExtention(string $namaFile, array $validExtention): bool
    {
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        return in_array($ekstensiGambar, $validExtention) ? false : true;
    }

    public function upload($folder, $tmpName, $namaFile)
    {
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        // generate nama gambar baru
        $namaFileBaru = $this->createRandomString();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        if (!move_uploaded_file($tmpName, $folder . $namaFileBaru)) {
            throw new Exception("Upload image failed");
        }

        return $namaFileBaru;
    }
}

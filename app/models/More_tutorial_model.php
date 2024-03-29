<?php
class More_tutorial_model extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMoreTutorialsBy(string $username, int $startIndexOfMoreTutorials): array
    {
        $numOfTutorials = R::count('tutorial', ' created_by = ? ', [$username]);
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
                    WHERE tutorial.created_by = :username
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
                        WHERE tutorial.created_by = :username AND liked_by IS NULL
                    ) AS tbl_tutorial
                ORDER BY tutorial_date DESC
                LIMIT :tutorialsPerPage OFFSET :startIndexOfMoreTutorials
            ";

            $tutorials = R::getAll($query, [':username' => $username, ':tutorialsPerPage' => TUTORIALS_PER_PAGE, ':startIndexOfMoreTutorials' => $startIndexOfMoreTutorials]);

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
        } else {
            $tutorials = array();
            return $tutorials;
        }
    }

    public function getMoreTutorials(int $startIndexOfMoreTutorials): array
    {
        return $this->getMoreTutorialsFromModelClass($startIndexOfMoreTutorials);
    }

    public function getMoreTutorialsForSearch(string $keyword, int $startIndexOfMoreTutorials): array
    {
        $numOfTutorials = R::count('tutorial', ' LOWER(title) LIKE ? ', ['%' . $keyword . '%']);
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
                    WHERE LOWER(tutorial.title) LIKE :q AND tutorial.is_revoke = 'N'
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
                        WHERE LOWER(tutorial.title) LIKE :q AND tutorial.is_revoke = 'N' AND liked_by IS NULL
                    ) AS tbl_tutorial
                ORDER BY tutorial_date DESC
                LIMIT :tutorialsPerPage OFFSET :startIndexOfMoreTutorials
            ";

            $tutorials = R::getAll($query, [':q' => "%$keyword%", ':tutorialsPerPage' => TUTORIALS_PER_PAGE, ':startIndexOfMoreTutorials' => $startIndexOfMoreTutorials]);

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
        } else {
            $tutorials = array();
            $listLevenshteinDistances = $this->searchWithLevenshteinDistance($keyword);

            $jlhIterasi = 0;
            if ((TUTORIALS_PER_PAGE + $startIndexOfMoreTutorials) < count($listLevenshteinDistances)) {
                $jlhIterasi = TUTORIALS_PER_PAGE;
            } else {
                $jlhIterasi = count($listLevenshteinDistances) - $startIndexOfMoreTutorials;
            }

            for ($i = 0; $i < $jlhIterasi; $i++) {

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
                        WHERE tutorial.id = :id
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
                            WHERE tutorial.id = :id AND liked_by IS NULL
                        ) AS tbl_tutorial
                ";

                $tutorial = R::getAll($query, [':id' => $listLevenshteinDistances[$startIndexOfMoreTutorials]['id']]);
                array_push($tutorials, $tutorial[0]);
                $startIndexOfMoreTutorials++;
            }

            $tutorials = $this->shortenTitle($tutorials);
            return $tutorials;
        }
    }

    public function getMoreTutorialsForBestSeller(int $startIndexOfMoreTutorials): array
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
                ORDER BY total_purchase DESC, tutorial_date DESC
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

    public function getMoreTutorialsForMostLiked(int $startIndexOfMoreTutorials): array
    {
        $numOfTutorials = R::count('tutorial');
        if ($numOfTutorials > 0) {
            $query = "
                SELECT 
                    COUNT(id_like_tutorial) AS total_like,
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
                            liked_tutorial.id as id_like_tutorial
                    FROM tutorial
                    FULL OUTER JOIN liked_tutorial ON tutorial.id=liked_tutorial.tutorial_id
                    WHERE tutorial.is_revoke = 'N'
                ) AS tbl_tutorial
                GROUP BY title,
                id,
                img_cover,
                created_by,
                prize,
                created_date,
                tutorial_date
                ORDER BY total_like DESC, tutorial_date DESC
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

    public function getMoreTutorialsForTutorialFrom(int $startIndexOfMoreTutorials, string $usernameTeacher): array
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
                    WHERE tutorial.created_by = :username  and tutorial.is_revoke = 'N'
                ) AS tbl_tutorial
                GROUP BY title,
                id,
                img_cover,
                created_by,
                prize,
                created_date,
                tutorial_date
                ORDER BY tutorial_date DESC
                LIMIT :tutorialsPerPage OFFSET :startIndexOfMoreTutorials
            ";

            $tutorials = R::getAll($query, [':username' => $usernameTeacher, ':tutorialsPerPage' => TUTORIALS_PER_PAGE, ':startIndexOfMoreTutorials' => $startIndexOfMoreTutorials]);

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
        } else {
            $tutorials = array();
            return $tutorials;
        }
    }

    public function getMoreTutorialsForCart(int $startIndexOfMoreTutorials): array
    {
        $numOfTutorials = R::count('tutorial');
        if ($numOfTutorials > 0) {
            $query = "
                    SELECT 
                    COUNT(id_like_tutorial) AS total_like,
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
                            liked_tutorial.id as id_like_tutorial
                    FROM tutorial
                    FULL OUTER JOIN liked_tutorial ON tutorial.id=liked_tutorial.tutorial_id
                    FULL OUTER JOIN cart ON tutorial.id::text = cart.id_tutorial::text
                    WHERE tutorial.is_revoke = 'N'
                    AND cart.username_student = :username AND cart.is_checkout = 'N'
                    AND cart.is_cancel = 'N'
                ) AS tbl_tutorial
                GROUP BY title,
                id,
                img_cover,
                created_by,
                prize,
                created_date,
                tutorial_date
                ORDER BY tutorial_date DESC
                LIMIT :tutorialsPerPage OFFSET :startIndexOfMoreTutorials
            ";

            $tutorials = R::getAll(
                $query, 
                [
                    ':username' =>  $_SESSION["username_student"],
                    ':tutorialsPerPage' => TUTORIALS_PER_PAGE, 
                    ':startIndexOfMoreTutorials' => $startIndexOfMoreTutorials
                ]
            );

            $tutorials = $this->shortenTitle($tutorials);

            return $tutorials;
        } else {
            $tutorials = array();
            return $tutorials;
        }

    }
}

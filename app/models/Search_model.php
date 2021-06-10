<?php
class Search_model extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function SearchTutorialsBy(array $keyword): array
    {
        if ($this->isDataEmpty($keyword)) {
            Flasher::setFlash('error', 'Failed', 'Data must be sent');
            return array();
        } elseif (!$this->doesMandatoryDataFilled($keyword)) {
            Flasher::setFlash('error', 'Failed', 'Keyword is mandatory');
            return array();
        } elseif ($this->isBreak($keyword['q'], "/^[a-zA-Z0-9 .,\-&]{6,50}$/")) {
            Flasher::setFlash('error', 'Failed', 'Search Format: Combination of letters and numbers, Length: 6 - 50');
            return array();
        } else {

            $tutorialsPerPage = 4;
            $numOfTutorials = R::count('tutorial', ' LOWER(title) LIKE ? ', ['%' . strtolower($keyword['q']) . '%']);
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
                        WHERE LOWER(tutorial.title) LIKE '%" . strtolower($keyword['q']) . "%' AND tutorial.is_revoke = 'N'
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
                            WHERE LOWER(tutorial.title) LIKE '%" . strtolower($keyword['q']) . "%' AND tutorial.is_revoke = 'N' AND liked_by IS NULL
                        ) AS tbl_tutorial
                    ORDER BY tutorial_date DESC
                    LIMIT " . $tutorialsPerPage . "
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

    public function getTotalOfSearchTutorials(array $keyword): int
    {
        return $this->isDataEmpty($keyword) ? 0 : R::count('tutorial', ' LOWER(title) LIKE ? AND is_revoke = ?', ['%' . strtolower($keyword['q']) . '%', 'N']);
    }

    public function purifyKeyword(string $keyword): string
    {
        return $this->purify($keyword);
    }
}
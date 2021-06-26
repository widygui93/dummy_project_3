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
            $numOfTutorials = R::count('tutorial', ' LOWER(title) LIKE ? AND is_revoke = ?', ['%' . strtolower($keyword['q']) . '%', 'N']);
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
                    LIMIT " . $tutorialsPerPage . "
                ";

                $tutorials = R::getAll($query, [':q' => "%" . strtolower($keyword['q']) . "%"]);

                $tutorials = $this->shortenTitle($tutorials);

                return $tutorials;
            } else {
                $tutorials = array();
                // $dataSources = explode(" ", $keyword['q']);
                // $tutorialTargets = array();
                // $tutorialTargets = R::getAll('SELECT title FROM tutorial WHERE is_revoke = ? ', ["N"]);
                // $dataTargets = array();

                // foreach ($tutorialTargets as $tutorialTarget) {
                //     $targets = explode(" ", $tutorialTarget["title"]);
                //     foreach ($targets as $target) {
                //         if (!in_array(strtolower($target), $dataTargets)) array_push($dataTargets, strtolower($target));
                //     }
                // }

                // foreach ($dataSources as $dataSource) {
                //     // lakukan fuzzy search dengan algo levenshtein distance
                //     // pake str_split() utk convert string into array
                // }

                $dataSources = strtolower($keyword['q']);
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

                $ids = "";
                foreach ($listLevenshteinDistances as $listLevenshteinDistance) {
                    $ids = $ids . '\'' . $listLevenshteinDistance['id'] . '\'' . ',';
                }

                $ids = substr($ids, 0, -1);

                $queryForLikes = <<< QUERY_FOR_LIKES
                SELECT COUNT(id) AS total_like, id, title, img_cover, created_by, prize, created_date, tutorial_date, is_revoke
                FROM (SELECT tutorial.id,tutorial.title,tutorial.img_cover,tutorial.created_by,to_char(tutorial.prize, '999,999,999') AS prize,to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,tutorial.created_date AS tutorial_date,tutorial.is_revoke,liked_tutorial.liked_by
                FROM tutorial JOIN liked_tutorial ON tutorial.id = liked_tutorial.tutorial_id WHERE tutorial.id IN ($ids)
                ) AS tbl_tutorial GROUP BY id,title, img_cover, created_by , prize,created_date, tutorial_date, is_revoke
                UNION
                QUERY_FOR_LIKES;

                $queryForNonLikes = <<< QUERY_FOR_NONLIKES
                SELECT 0 AS total_like,id, title, img_cover, created_by , prize,created_date, tutorial_date, is_revoke
                FROM (SELECT tutorial.id,tutorial.title,tutorial.img_cover,tutorial.created_by,to_char(tutorial.prize, '999,999,999') AS prize,to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,tutorial.created_date AS tutorial_date,tutorial.is_revoke,liked_tutorial.liked_by
                FROM tutorial LEFT JOIN liked_tutorial ON tutorial.id = liked_tutorial.tutorial_id WHERE tutorial.id IN ($ids) AND liked_by IS NULL
                ) AS tbl_tutorial ORDER BY tutorial_date DESC LIMIT $tutorialsPerPage
                QUERY_FOR_NONLIKES;

                $tutorials = R::getAll($queryForLikes . " " . $queryForNonLikes);

                $tutorials = $this->shortenTitle($tutorials);

                return $tutorials;


                // lakukan fuzzy search dengan algo levenshtein distance
                // pake str_split() utk convert string into array
                // return $tutorials;
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
    // kerjain fuzzy search
}

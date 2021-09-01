<?php
class Detail_tutorial_model extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDetailTutorialBy(string $id): string
    {
        if ($this->isIDNotUUID($id)) {
            return <<< RESULT_TEMPLATE
			<p>ID is invalid data type</p>
			RESULT_TEMPLATE;
        } elseif ($this->isIdNotAvailable($id)) {
            return <<< RESULT_TEMPLATE
			<p>Tutorial is not available</p>
			RESULT_TEMPLATE;
        } elseif ($this->isIDRevoked($id)) {
            return <<< RESULT_TEMPLATE
            <p>Tutorial has been revoked</p> 
            RESULT_TEMPLATE;
        } else {
            $detailTutorial = $this->getDetail($id);
            $totalPurchased = $this->getTotalPurchased($id);
            $totalLiked = $this->getTotalLiked($id);
            $tags = $this->getTags($detailTutorial[0]['tutorial_date'], $totalPurchased, $totalLiked);

            $detailTutorial[0]['total_purchased'] = $totalPurchased;
            $detailTutorial[0]['total_like'] = $totalLiked;
            $detailTutorial[0]['tags'] = $tags;

            $subtitleClass = isset($detailTutorial[0]['subtitle']) ? 'with-subtitle' : 'without-subtitle';

            $tagTemplates = '';

            if (count($detailTutorial[0]['tags']) > 0) {
                $tagsList = "<ul class='tags'>";
                foreach ($detailTutorial[0]['tags'] as $tag) {
                    if ($tag == "Latest Tutorial") $tagsList = $tagsList .  "<li><a href='" . BASEURL . "/Latest_tutorial'>Latest Tutorial</a></li>";
                    if ($tag == "Best Seller")     $tagsList = $tagsList .  "<li><a href='" . BASEURL . "/Best_seller_tutorial'>Best Seller</a></li>";
                    if ($tag == "Most Liked")      $tagsList = $tagsList .  "<li><a href='" . BASEURL . "/Most_liked_tutorial'>Most Liked</a></li>";
                }
                $tagsList = $tagsList . "</ul>";
                $tagTemplates = "<div class='tags-container'><p class='label-tags'>Tags:</p>" . $tagsList . "</div>";
            }

            $byTemplate = BASEURL . "/Tutorial_from_teacher/viewTutorial/" . $detailTutorial[0]['created_by'];

            return <<< RESULT_TEMPLATE
            <img src='http://localhost/widy/project/dummy_project_3/app/core/videos/cover-img/{$detailTutorial[0]['img_cover']}' class='img-cover'>
            <h3 class='title'>{$detailTutorial[0]['title']}</h3>
            <div class='createdby-container'>
                <span class="label-by">By <a href='{$byTemplate}' class='created-by'>{$detailTutorial[0]['created_by']}</a></span>
            </div>
            <div class='prize-container'>
                <img src='http://localhost/widy/project/dummy_project_3/public/svg/green_dollar_icon.svg' class='dollar-logo' alt='cost'>
                <span class='prize'>{$detailTutorial[0]['prize']}</span>
            </div>
            <div class='like-container'>
                <img src='http://localhost/widy/project/dummy_project_3/public/svg/Green_Heart_Icon.svg' class='like-logo' alt='like'>
                <p>{$detailTutorial[0]['total_like']} Likes</p>
            </div>
            <p class='level'>Level: {$detailTutorial[0]['level']}</p>
            <p class='purchased-by'>Purchased By: {$detailTutorial[0]['total_purchased']} Students</p>
            <p class='created-dt'>Created on: {$detailTutorial[0]['created_date']}</p>
            <p class='duration'>Duration: {$detailTutorial[0]['video_duration']}</p>
            <span class='{$subtitleClass}'>Subtitle</span>
            {$tagTemplates}
            <div class='desc-container'>
                <p class="label-desc">Desc:</p>
                <p class='description'>{$detailTutorial[0]['description']}</p>
            </div>
            RESULT_TEMPLATE;
        }
    }

    private function getDetail(string $id): array
    {

        $query = "
            SELECT title,
                    img_cover,
                    created_by,
                    to_char(prize, '999,999,999') AS prize,
                    to_char(created_date, 'Month DD,YYYY') AS created_date,
                    created_date AS tutorial_date,
                    level,
                    video_duration,
                    subtitle,
                    description 
            FROM tutorial WHERE id = :id AND is_revoke = 'N'
        ";
        return R::getAll($query, [':id' => $id]);
    }

    private function getTotalPurchased(string $id): int
    {
        return R::count('purchased_tutorial', " tutorial_id = :id AND is_revoke = 'N'", [':id' => $id]);
    }

    private function getTotalLiked(string $id): int
    {
        return R::count('liked_tutorial', " tutorial_id = :id AND is_revoke = 'N'", [':id' => $id]);
    }

    private function getTags(string $tutorialDate, int $totalPurchased, int $totalLiked): array
    {
        $possibleTags = [];

        $createdTutorialTimestamp = strtotime($tutorialDate);
        $currentTimestamp = strtotime(date("Y-m-d H:i:s"));
        $selisihDalamTimestamp = $currentTimestamp - $createdTutorialTimestamp;
        // ubah detik ke hari
        $selisihDalamHari = $selisihDalamTimestamp / 86400;

        if ($selisihDalamHari < MAX_DAYS_LATEST_TUTORIAL) $possibleTags[] = 'Latest Tutorial';
        if ($totalPurchased > BEST_SELLER_THRESHOLD)      $possibleTags[] = 'Best Seller';
        if ($totalLiked > MOST_LIKED_THRESHOLD)           $possibleTags[] = 'Most Liked';

        return $possibleTags;
    }
}

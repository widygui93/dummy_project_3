<div class="tutorial-section">
    <div class="tutorial-wrap">
        <?php foreach ($data['tutorials'] as $tutorial): ?>
            <div class="tutorial">
                <div class="tutorial-video">
                    <img src="../app/core/videos/cover-img/<?= $tutorial['img_cover'] ?>" alt="video-poster">
                </div>
                <div class="tutorial-info">
                    <div class="info-1">
                        <span style="display: none;"><?= $tutorial['id'] ?></span>
                        <span class="tutorial-title"><a><?= $tutorial['title'] ?></a></span>
                        <span class="tooltiptext">Click for details</span>
                    </div>
                    <div class="info-2">
                        <span class="tutorial-author">By <?= $tutorial['created_by'] ?></span>
                        <small class="tutorial-date"><?= $tutorial['created_date'] ?></small>
                    </div>
                </div>
                <div class="tutorial-play">
                    <div class="play-button">
                        <a href="#">Play</a>
                    </div>
                    <div class="play-info">
                        <span class="tutorial-like">
                            <img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
                            <span><?= $tutorial['total_like'] ?></span>
                        </span>
                        <span class="tutorial-cost">
                            <img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
                            <span><?= $tutorial['prize'] ?></span>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>  
    </div>
    <div class="tutorial-page">
        <ul>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#">7</a></li>
            <li><a href="#">8</a></li>
        </ul>
    </div>
    <div id="modalDetailTutorial" class="modal">
        <div class="modal-content">
            <span class="close-detail-tutorial">&times;</span>
            <h3>Tutorial Detail</h3>
            <div class="detail-tutorial"></div>
        </div>
    </div>
</div>
<main class="dashboard-teacher">
    <div class="row-header">
        <h3>Upload Your Tutorial</h3>
    </div>
    <div class="tutorial-form">
        <form action="<?= BASEURL; ?>/Dashboard_teacher/upload" method="post" autocomplete="off">
            <div class="form-group item-title">
                <label for="title">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    minlength="6" 
                    maxlength="50"
                    pattern="^[a-zA-Z0-9 .,-&]*$"
                    class="form-control" 
                    placeholder="Your tutorial title" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group item-level">
                <label for="level">Level</label>
                <select name="level" id="level">
                    <option value="all-level">All Level</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advance">Advance</option>
                </select>
            </div>
            <div class="form-group item-prize">
                <label for="prize">Prize</label>
                <input 
                    type="text" 
                    name="prize" 
                    id="prize" 
                    pattern="^[0-9]*$"
                    class="form-control" 
                    placeholder="0" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group item-desc">
                <label for="desc">Description</label>
                <textarea 
                    id="desc"
                    name="desc"
                    minlength="10"
                    maxlength="300"
                    placeholder="Description..."
                    required></textarea>
            </div>
            <div class="form-group item-vid">
                <label for="video">Upload Video</label>
                <input type="file" name="video" id="video" class="form-control" required>
                <video poster="<?= BASEURL; ?>/img/default-video.png">
                    <source id="vid-src" src="#" type="video/webm" />
                    Your Browser is not supported.
                </video>
            </div>
            <div class="form-group item-img-cover">
                <label for="img-cover">Upload image cover</label>
                <input type="file" name="img-cover" id="img-cover-input" class="form-control" required>
                <img id="img-cover" src="<?= BASEURL; ?>/img/default-img.jpg" />
            </div>
            <div class="form-group item-btn">
                <button type="submit" name="upload" class="btn btn-outline-dark">Upload</button>
            </div>
        </form>
    </div>
    <div class="tutorial-display">
        <h3>Your Tutorial</h3>
        <div class="tutorial-wrap">
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
            <div class="tutorial">
				<div class="tutorial-video">
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-play">
					<div class="play-button">
						<a href="#">Play</a>
					</div>
					<div class="play-info">
						<span class="tutorial-like">
							<img src="<?= BASEURL; ?>/svg/Green_Heart_Icon.svg" alt="like">
							<span>23K</span>
						</span>
						<span class="tutorial-cost">
							<img src="<?= BASEURL; ?>/svg/green_dollar_icon.svg" alt="cost">
							<span>45K</span>
						</span>
					</div>
				</div>
            </div>
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
    </div>
</main>
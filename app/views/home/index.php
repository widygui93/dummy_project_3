
<main class="main">
	<div class="call-to-action">
		<div class="cta-content">
			<h1>Welcome to Unemi</h1>
			<h3>Your Learing Platform</h3>
			<?php if( !(isset($_SESSION["login-teacher"]) || isset($_SESSION["login-student"])) ): ?>
				<div><a href="<?= BASEURL; ?>/Signup">Sign Up</a></div>
			<?php endif; ?>
		</div>
	</div>
	<div class="latest-tutorial">
		<h3>Latest Tutorial</h3>
		<div class="tutorial-wrap">
			<div class="tutorial">
				<div class="tutorial-video">
					<!-- <video poster="../app/core/videos/cover-img/sample.png" controls> -->
						<!-- <source src="../app/core/videos/cat-herd.webm" type="video/webm" /> -->
						<!-- Your Browser is not supported. -->
					<!-- </video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
					<!-- <video>
						<source src="../app/core/videos/flower.webm" type="video/webm" />
						Your Browser is not supported.
					</video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
					<!-- <video>
						<source src="../app/core/videos/cat-herd.webm" type="video/webm" />
						Your Browser is not supported.
					</video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
					<!-- <video>
						<source src="../app/core/videos/cat-herd.webm" type="video/webm" />
						Your Browser is not supported.
					</video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
					<!-- <video>
						<source src="../app/core/videos/cat-herd.webm" type="video/webm" />
						Your Browser is not supported.
					</video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
					<!-- <video>
						<source src="../app/core/videos/cat-herd.webm" type="video/webm" />
						Your Browser is not supported.
					</video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
					<!-- <video>
						<source src="../app/core/videos/cat-herd.webm" type="video/webm" />
						Your Browser is not supported.
					</video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
					<!-- <video>
						<source src="../app/core/videos/cat-herd.webm" type="video/webm" />
						Your Browser is not supported.
					</video> -->
					<img src="../app/core/videos/cover-img/sample.png" alt="video-poster">
				</div>
				<div class="tutorial-info">
					<div class="info-1">
						<span class="tutorial-title"><a href="#">Learning X for Beginner</a></span>
						<span class="tooltiptext">Click for details</span>
					</div>
					<div class="info-2">
						<span class="tutorial-author">By John D.J.A</span>
						<small class="tutorial-date">September 25,2020</small>
					</div>
				</div>
				<div class="tutorial-purchase">
					<div class="purchase-button">
						<a href="#">Purchase</a>
					</div>
					<div class="purchase-info">
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
	<div class="student-testi">
		<h3>Student Testimony</h3>
		<div class="student-testi-wrap">
			<div class="testi fade">
				<div class="numbertext">1 / 5</div>
				<div class="testi-head">
					<img src="http://placehold.it/150x150" alt="testi-img">
				</div>
				<div class="testi-main">
					<span class="student-name">John McCarty</span>
					<p class="testi-text">In Unemi, I want to learn whenever I can. If it's still unclear, the video can also be replay</p>
				</div>
			</div>
			<div class="testi fade">
				<div class="numbertext">2 / 5</div>
				<div class="testi-head">
					<img src="http://placehold.it/150x150" alt="testi-img">
				</div>
				<div class="testi-main">
					<span class="student-name">Caleb Santos</span>
					<p class="testi-text">In Unemi, I want to learn whenever I can. If it's still unclear, the video can also be replay</p>
				</div>
			</div>
			<div class="testi fade">
				<div class="numbertext">3 / 5</div>
				<div class="testi-head">
					<img src="http://placehold.it/150x150" alt="testi-img">
				</div>
				<div class="testi-main">
					<span class="student-name">Mary Anne</span>
					<p class="testi-text">In Unemi, I want to learn whenever I can. If it's still unclear, the video can also be replay</p>
				</div>
			</div>
			<div class="testi fade">
				<div class="numbertext">4 / 5</div>
				<div class="testi-head">
					<img src="http://placehold.it/150x150" alt="testi-img">
				</div>
				<div class="testi-main">
					<span class="student-name">Jack Doe</span>
					<p class="testi-text">In Unemi, I want to learn whenever I can. If it's still unclear, the video can also be replay</p>
				</div>
			</div>
			<div class="testi fade">
				<div class="numbertext">5 / 5</div>
				<div class="testi-head">
					<img src="http://placehold.it/150x150" alt="testi-img">
				</div>
				<div class="testi-main">
					<span class="student-name">Kelly Sims</span>
					<p class="testi-text">In Unemi, I want to learn whenever I can. If it's still unclear, the video can also be replay</p>
				</div>
			</div>
			<a class="prev">&#10094;</a>
			<a class="next">&#10095;</a>
		</div>
	</div>
	<div class="list-teacher">
		<h3>Teacher List</h3>
		<div class="list-teacher-wrap">
			<div class="teacher fade">
				<div class="numbertext">1 / 3</div>
				<div class="teacher-head">
					<img src="http://placehold.it/150x150" alt="teacher-img">
				</div>
				<div class="teacher-main">
					<span class="teacher-name">John</span>
					<span class="teacher-specialist">Economy Lecturer</span>
				</div>
			</div>
			<div class="teacher fade">
				<div class="numbertext">2 / 3</div>
				<div class="teacher-head">
					<img src="http://placehold.it/150x150" alt="teacher-img">
				</div>
				<div class="teacher-main">
					<span class="teacher-name">Erik</span>
					<span class="teacher-specialist">Sosiology Expert</span>
				</div>
			</div>
			<div class="teacher fade">
				<div class="numbertext">3 / 3</div>
				<div class="teacher-head">
					<img src="http://placehold.it/150x150" alt="teacher-img">
				</div>
				<div class="teacher-main">
					<span class="teacher-name">Kane</span>
					<span class="teacher-specialist">Prof of Math</span>
				</div>
			</div>
			<a class="prev-teacher">&#10094;</a>
			<a class="next-teacher">&#10095;</a>
		</div>
	</div>
	<div class="comparison">
		<h3>Why do you need to use Unemi?</h3>
		<div class="comparison-table">
			<div class="comparison-table-head">
				<button class="tab-conven">Conventional</button>
				<button class="tab-unemi">Unemi</button>
			</div>
			<div class="comparison-table-main">
				<table>
					<tr>
						<th>Features</th>
						<th class="conven-feature">Conventional</th>
						<th class="unemi-feature">Unemi</th>
					</tr>
					<tr>
						<td>Price</td>
						<td class="conven-feature">Unpredictable</td>
						<td class="unemi-feature">Predictable</td>
					</tr>
					<tr>
						<td>Personality</td>
						<td class="conven-feature">Monoton</td>
						<td class="unemi-feature">Adaptive</td>
					</tr>
					<tr>
						<td>Learning Schedule</td>
						<td class="conven-feature">Predetermined</td>
						<td class="unemi-feature">Flexible</td>
					</tr>
					<tr>
						<td>Location</td>
						<td class="conven-feature">Onsite</td>
						<td class="unemi-feature">Online</td>
					</tr>
					<tr>
						<td>Participants</td>
						<td class="conven-feature">More than 40 Students</td>
						<td class="unemi-feature">one on one</td>
					</tr>
					<tr>
						<td>Method</td>
						<td class="conven-feature">Out of date</td>
						<td class="unemi-feature">Up to date</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</main>



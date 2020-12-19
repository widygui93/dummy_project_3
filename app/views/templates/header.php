<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Unemi</title>
	<link rel="stylesheet" href="<?= BASEURL; ?>/css/header-style.css">
	<link rel="stylesheet" href="<?= $data['style']; ?>">
	<link rel="stylesheet" href="<?= BASEURL; ?>/css/footer-style.css">
	<!-- CDN sweetalert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
	<div class="grid-container">
		<header class="header">
			<div class="header-wrapper">
				<div class="logo-wrapper">
					<a href="<?= BASEURL; ?>">
						<img src="<?= BASEURL; ?>/img/logo.png" alt="logo-img" class="logo">
					</a>
				</div>
				<div class="search-bar">
					<form action="" method="get">
						<input type="search" placeholder="Search Tutorial" name="q" autocomplete="off">
					</form>
				</div>
				<div class="login-signup-logout-wrapper">
					<?php if( isset($_SESSION["login-teacher"]) || isset($_SESSION["login-student"]) ): ?>
						<div class="logout-wrapper">
							<a href="<?= BASEURL; ?>/Logout">Log out</a>
						</div>
					<?php else: ?>
						<div class="login-signup-wrapper">
							<div class="login-wrapper">
								<a href="<?= BASEURL; ?>/Login">Log in</a>
							</div>
							<div class="signup-wrapper">
								<a href="<?= BASEURL; ?>/Signup">Sign Up</a>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="menu-btn-wrapper">
					<div class="menu-btn">
						<div class="menu-btn__burger"></div>
					</div>
				</div>
				<div class="menu-navbar">
					<ul>
						<li><a href="">Latest Tutorial</a></li>
						<li><a href="">Best Seller Tutorial</a></li>
						<li><a href="">Most Liked Tutorial</a></li>
						<?php if( isset($_SESSION["login-teacher"]) || isset($_SESSION["login-student"]) ): ?>
							<li><a href="">Dashboard</a></li>
							<li><a href=""><?= $_SESSION["username-teacher"] ?? $_SESSION['username-student'] ?></a></li>
						<?php endif; ?>
					</ul>
				</div>
				<?php if( isset($_SESSION["login-teacher"]) || isset($_SESSION["login-student"]) ): ?>
					<div class="notif-coin">
						<div class="notif">
							<a href="">999</a>
						</div>
						<div class="coin">
							<span>$600K</span>
						</div>
					</div>
				<?php endif; ?>
    		</div>
		</header>
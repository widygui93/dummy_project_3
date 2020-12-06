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
				<div class="login-signup-wrapper">
					<div class="login-wrapper">
						<a href="#">Log in</a>
					</div>
					<div class="signup-wrapper">
						<a href="<?= BASEURL; ?>/Signup">Sign Up</a>
					</div>
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
						<!-- <li><a href="">Dashboard</a></li> -->
						<!-- <li><a href="">Profile</a></li> -->
					</ul>
				</div>
    		</div>
		</header>
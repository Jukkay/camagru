<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
	<link rel="icon" type="image/x-icon" href="/assets/favicon.svg">
	<title>Camagru</title>
</head>
<body>
	<div class="container is-max-desktop">
		<nav class="navbar" role="navigation" aria-label="main navigation">
			<div class="navbar-brand">
				<a class="navbar-item pt-3" href="/">
					<div class="">
						<img src="../assets/camagru_logo.svg" alt="Main page">
					</div>
				</a>
				<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</a>
			</div>
			<div class="navbar-menu">
				<div class="navbar-start">
					<a class="navbar-item" href="/gallery">Gallery</a>
					<a class="navbar-item" href="/camera">Take picture</a>
				</div>
				<div class="navbar-end">
					<div class="navbar-item">
						<div class="buttons">
							<?php
								if (isset($_SESSION['user'])) {
									echo '<a class="button" href="logout">Logout</a>';
								}
								else {
									echo '<a class="button is-primary" href="signup">Sign up</a>
									<a class="button" href="login">Login</a>
									<a class="button" href="logout">Logout</a>';
								}
							?>
						</div>
					</div>
					<div class="navbar-item">
						<a class="navbar-item" href="/profile" alt="Profile">
							<span class="icon is-medium">
								<svg style="width:32px;height:32px" viewBox="0 0 24 24">
								<path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
								</svg>
							</span>
						</a>
					</div>
				</div>

			</div>
		</nav>

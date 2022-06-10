<?php

require_once "classes/dbh.class.php";

if (!isset($_GET['validation_key'])) {
	echo '
		<section class="section">
		<h3 class="title is-3">Check your email to confirm your account</h3>
		</section>
	';
	return;
}
require_once "scripts/check_validation_key.php";
?>
<section class="section">
	<h3 class="title is-3">Email address validated</h3>
	<h3 class="title is-3">Welcome to Camagru</h3>
	<p><a href="/login">Please login here.</a></p>
</section>

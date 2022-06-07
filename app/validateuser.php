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
try {

	$validation_key = $_GET['validation_key'];
	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("UPDATE users SET validated = ? WHERE validation_key = ?;");
	$statement->execute(['1', $validation_key]);
}
catch(Exception $e) {
	echo $e->getMessage();
}
?>
<section class="section">
	<h3 class="title is-3">Email address validated</h3>
	<h3 class="title is-3">Welcome to Camagru</h3>
	<p><a href="/login">Please login here.</a></p>
</section>

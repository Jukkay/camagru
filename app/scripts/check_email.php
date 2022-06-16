<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_GET['email']))
	return;
$email = $_GET['email'];
try {

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT * FROM users WHERE email = ?;");
	$statement->execute([$email]);
	$emailExists = $statement->fetch();
	if ($emailExists && $emailExists['user_id'] != $_SESSION['user_id']) {
		echo 'emailtaken';
		return;
	}
	echo 'ok';
} catch (Exception $e) {
	echo $e->getMessage();
}

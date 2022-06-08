<?php
require_once "classes/dbh.class.php";

if (!isset($_GET['email']))
	return;

try {
	$email = $_GET['email'];

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT email FROM users WHERE email = ?;");
	$statement->execute([$email]);
	$emailExists = $statement->fetchAll();
	if ($emailExists) {
		echo 'emailtaken';
		return;
	}
	echo 'ok';
} catch (Exception $e) {
	echo $e->getMessage();
}
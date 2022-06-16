<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_GET['username']))
	return;

$username = $_GET['username'];
try {

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT * FROM users WHERE username = ?;");
	$statement->execute([$username]);
	$userExists = $statement->fetch();
	if (!$userExists) {
		echo 'username_available';
		return;
	}
	if (isset($_SESSION['username'])) {
		if ($userExists['username'] == $_SESSION['username']) {
			echo 'username_available';
			return;
		}
	}
	echo 'username_exists';
} catch (Exception $e) {
	echo $e->getMessage();
}

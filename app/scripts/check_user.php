<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_GET['username']))
	return;

$username = $_GET['username'];
try {

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT username FROM users WHERE username = ?;");
	$statement->execute([$username]);
	$userExists = $statement->fetch();
	if ($userExists && $userExists['username'] != $_SESSION['username']) {
		echo 'username_exists';
		return;
	}
	echo 'username_available';
} catch (Exception $e) {
	echo $e->getMessage();
}

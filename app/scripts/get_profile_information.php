<?php
require_once "../classes/dbh.class.php";
$username = $_GET['username'];

try {
	$dbh = new Dbh;
	$pdo = $dbh->connect();

	$statement = $pdo->prepare("SELECT * FROM users WHERE `username` = ?;");
	$statement->execute([$username]);
	$userinfo = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "Error: " . $e->getMessage();
}

if (!$userinfo) {
	echo "No user found" . PHP_EOL;
	return;
}
include "../components/profile_information.php";

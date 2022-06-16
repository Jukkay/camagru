<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_POST['username']) || !isset($_POST['password'])) {
	echo 'invalidparameters';
	return;
}
try {

	$dbh = new Dbh;
	$pdo = $dbh->connect();

	$statement = $pdo->prepare("SELECT * FROM users WHERE username = ?;");
	$statement->execute([$_POST['username']]);
	$userinfo = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$userinfo) {
		echo 'invaliduser';
		return;
	}
	if (!password_verify($_POST['password'], $userinfo['password'])) {
		echo 'invalidpassword';
		return;
	}
	if (!$userinfo['validated']) {
		echo 'notvalidated';
		return;
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}

$_SESSION['username'] = $userinfo['username'];
$_SESSION['name'] = $userinfo['name'];
$_SESSION['user_id'] = $userinfo['user_id'];
$_SESSION['admin'] = $userinfo['admin'];
$_SESSION['profile_image'] = $userinfo['profile_image'];
echo 'ok';

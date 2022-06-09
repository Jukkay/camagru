<?php
require_once "../classes/dbh.class.php";

if (!isset($_POST['user_id']) ||
	!isset($_POST['oldpassword']) ||
	!isset($_POST['password'])) {
		echo 'invalid paremeters';
		return;
}

try {
	$user_id = $_POST['user_id'];
	$oldpassword = $_POST['oldpassword'];
	$password = $_POST['password'];

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT * FROM users WHERE `user_id` = ?;");
	$statement->execute([$user_id]);
	$userinfo = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$userinfo) {
		echo 'invalid_user';
		return;
	}
	if (!password_verify($oldpassword, $userinfo['password'])) {
		echo 'invalid_password';
		return;
	}
	$password = password_hash($password, PASSWORD_ARGON2ID);
	$statement = $pdo->prepare("UPDATE users SET `password` = ? WHERE `user_id` = ?;");
	$statement->execute([$password, $user_id]);
	echo 'ok';
}
catch (Exception $e) {
	echo $e->getMessage();
}

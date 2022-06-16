<?php
if (!isset($_POST['password_reset_key'])) {
	return;
}
if (!isset($_POST['password'])) {
	return;
}
require_once "../classes/dbh.class.php";

try {
	$password_reset_key = $_POST['password_reset_key'];
	$password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT * FROM users WHERE password_reset_key = ?;");
	$statement->execute([$password_reset_key]);
	$userinfo = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$userinfo) {
		echo 'invalid_key';
		return;
	}
	$statement = $pdo->prepare("UPDATE users SET `password` = ? WHERE `password_reset_key` = ?;");
	$statement->execute([$password, $password_reset_key]);
	echo 'ok';
}
catch (Exception $e) {
	echo $e->getMessage();
}

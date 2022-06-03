<?php
require_once "../classes/dbh.class.php";

if (empty($_POST['username']) || empty($_POST['passwd']) || $_POST['submit'] != 'OK') {
	header("Location: /login");
	return;
}
$dbh = new Dbh;
$pdo = $dbh->connect();

$statement = $pdo->prepare("SELECT * FROM users WHERE username = ?;");
$statement->execute([$_POST['username']]);
$userinfo = $statement->fetch(PDO::FETCH_ASSOC);
if (!$userinfo) {
	header("Location: /login?error=invaliduser");
	return ;
}
if (!password_verify($_POST['passwd'], $userinfo['password'])) {
		header("Location: /login?error=invalidpasswd");
		return;
}
$_SESSION['username'] = $userinfo['username'];
$_SESSION['name'] = $userinfo['name'];
$_SESSION['user_id'] = $userinfo['user_id'];
$_SESSION['admin'] = $userinfo['admin'];
$_SESSION['profile_image'] = $userinfo['profile_image'];
header("Location: /");


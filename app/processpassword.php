<?php
session_start();
require_once "classes/dbh.class.php";

if (empty($_POST['oldpw'])) {
	header("Location: /updatepassword?error=missingoldpw");
	return;
}
if (empty($_POST['passwd'])) {
	header("Location: /updatepassword?error=passwdempty");
	return;
}
if (empty($_POST['passwd2'])) {
	header("Location: /updatepassword?error=passwd2empty");
	return;
}

if ($_POST['passwd'] !== $_POST['passwd2']) {
	header("Location: /updatepassword?error=passwdnotmatch");
	return;
}
if ($_POST['submit'] != 'OK' ||
	!isset($_POST['user_id']) ||
	$_POST['user_id'] == 0 ||
	$_POST['user_id'] != $_SESSION['user_id'])
	return;

$dbh = new Dbh;
$pdo = $dbh->connect();

$statement = $pdo->prepare("SELECT * FROM users WHERE `user_id` = ?;");
$statement->execute([$_POST['user_id']]);
$userinfo = $statement->fetch(PDO::FETCH_ASSOC);
if (!$userinfo) {
	header("Location: /updatepassword?error=invaliduser");
	return ;
}
if (!password_verify($_POST['oldpw'], $userinfo['password'])) {
		header("Location: /updatepassword?error=oldpwmismatch");
		return;
}
$password = password_hash($password, PASSWORD_ARGON2ID);
$statement = $pdo->prepare("UPDATE users SET `password` = ? WHERE `user_id` = ?;");
$statement->execute([$password, $_POST['user_id']]);
include('logout.php');
header("Location: /login");
foreach ($array as &$user) {
	if ($user['login'] == $_POST['login'] && $user['passwd'] == hash("whirlpool", $_POST['oldpw'])) {
		$user['passwd'] = hash("whirlpool", $_POST['newpw']);
		file_put_contents($filename, serialize($array));
		echo "OK\n";
		include('logout.php');
		header("Location: ./index.php");
		return;
	}
}
echo "ERROR\n";
?>
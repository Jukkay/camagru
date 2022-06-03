<?php
require_once "../classes/dbh.class.php";
if (empty($_POST['username'])) {
	header("Location: /signup?error=usernameempty");
	return;
}
if (empty($_POST['passwd'])) {
	header("Location: /signup?error=passwdempty");
	return;
}
if (empty($_POST['passwd2'])) {
	header("Location: /signup?error=passwd2empty");
	return;
}
if (empty($_POST['tc']) || $_POST['tc'] != TRUE) {
	header("Location: /signup?error=passwd2empty");
	return;
}
if ($_POST['passwd'] !== $_POST['passwd2']) {
	header("Location: /signup?error=passwdnotmatch");
	return;
}
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['passwd'];
$email = $_POST['email'];

// connect to database
$dbh = new Dbh;
$pdo = $dbh->connect();
// Check if username is taken
//
$statement = $pdo->prepare("SELECT username FROM users WHERE username = ?;");
$statement->execute([$username]);
$userExists = $statement->fetchAll();
if ($userExists) {
	header("Location: /signup?error=usernametaken");
	return;
}
// check if email is taken
$statement = $pdo->prepare("SELECT email FROM users WHERE email = ?;");
$statement->execute([$email]);
$emailExists = $statement->fetchAll();
if ($emailExists) {
	header("Location: /signup?error=emailtaken");
	return;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header("Location: /signup?error=invalidemail");
	return;
}
try {
	$statement = $pdo->prepare("INSERT INTO users (`name`, username, `password`, email) VALUES (?, ?, ?, ?);");
	$statement->execute([
		$name,
		$username,
		password_hash($password, PASSWORD_ARGON2ID),
		$email
	]);
	header("Location: /login?status=success");
	return;

}
catch (PDOException $pe) {
	echo $pe->getMessage();
}

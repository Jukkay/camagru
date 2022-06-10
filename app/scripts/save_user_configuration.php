<?php
session_start();
require_once "../classes/dbh.class.php";

try {
	if (empty($_POST['user_id']) || $_POST['user_id'] == '0' || $_POST['user_id'] != $_SESSION['user_id'])
		return;

	$user_id = $_POST['user_id'];
	$dbh = new Dbh;
	$pdo = $dbh->connect();

	if (isset($_POST['name'])) {
		$name = $_POST['name'];
		$statement = $pdo->prepare("UPDATE users SET `name` = ? WHERE `user_id` = ?;");
		$statement->execute([$name, $_POST['user_id']]);
	}
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
		$statement = $pdo->prepare("UPDATE users SET `username` = ? WHERE `user_id` = ?;");
		$statement->execute([$username, $_POST['user_id']]);
		$_SESSION['username'] = $username;
	}
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		$statement = $pdo->prepare("UPDATE users SET `email` = ? WHERE `user_id` = ?;");
		$statement->execute([$email, $_POST['user_id']]);
	}
	if (isset($_POST['biography'])) {
		$biography = htmlspecialchars($_POST['biography']);
		if (strlen($biography) > 4096)
			return;
		$statement = $pdo->prepare("UPDATE users SET `biography` = ? WHERE `user_id` = ?;");
		$statement->execute([$biography, $_POST['user_id']]);
	}
	if (isset($_POST['email_notification'])) {
		$statement = $pdo->prepare("UPDATE users SET `email_notification` = ? WHERE `user_id` = ?;");
		$statement->execute(['1', $_POST['user_id']]);
	}
	else {
		$statement = $pdo->prepare("UPDATE users SET `email_notification` = ? WHERE `user_id` = ?;");
		$statement->execute(['0', $_POST['user_id']]);
	}

}
catch (Exception $e) {
	echo $e->getMessage();
}

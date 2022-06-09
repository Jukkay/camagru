<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['user_id']) || $_POST['user_id'] == '0' || $_POST['user_id'] != $_SESSION['user_id'])
		return;
	// connect to database
	$user_id = $_POST['user_id'];
	$dbh = new Dbh;
	$pdo = $dbh->connect();

	// Check if username is taken
	//
	function check_username($username, $user_id) {
		$dbh = new Dbh;
		$pdo = $dbh->connect();
		$statement = $pdo->prepare("SELECT username FROM users WHERE username = ? AND `user_id` != ?;");
		$statement->execute([$username, $user_id]);
		$userExists = $statement->fetchAll();
		if ($userExists) {
			header("Location: /controlpanel?error=usernametaken");
			return false;
		}
		return true;
	}

	// check if email is taken
	function check_email($email, $user_id) {
		$dbh = new Dbh;
		$pdo = $dbh->connect();
		$statement = $pdo->prepare("SELECT email FROM users WHERE email = ? AND `user_id` != ?;");
		$statement->execute([$email, $user_id]);
		$emailExists = $statement->fetchAll();
		if ($emailExists) {
			header("Location: /controlpanel?error=emailtaken");
			return false;
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: /controlpanel?error=invalidemail");
			return false;
		}
		return true;
	}

	// updates

	if (isset($_POST['name'])) {
		$name = $_POST['name'];
		$statement = $pdo->prepare("UPDATE users SET `name` = ? WHERE `user_id` = ?;");
		$statement->execute([$name, $_POST['user_id']]);
	}
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
		if (!check_username($username, $user_id))
			return;
		$statement = $pdo->prepare("UPDATE users SET `username` = ? WHERE `user_id` = ?;");
		$statement->execute([$username, $_POST['user_id']]);
	}
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		if (!check_email($email, $user_id))
			return;
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

	header("Location: /controlpanel?status=success");

}
catch (PDOException $pe) {
	echo $pe->getMessage();
}

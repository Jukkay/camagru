<?php
require_once "../classes/dbh.class.php";

if (!isset($_POST['username']) ||
	!isset($_POST['email']) ||
	!isset($_POST['password']) ||
	!isset($_POST['tc']) ||
	$_POST['tc'] != TRUE) {
	return;
}

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$validation_key = md5(uniqid(rand(), true));

try {
	// write to database
	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO users (`name`, username, `password`, email, validation_key) VALUES (?, ?, ?, ?, ?);");
	$statement->execute([
		$name,
		$username,
		password_hash($password, PASSWORD_ARGON2ID),
		$email,
		$validation_key
	]);
}
catch (PDOException $e) {
		echo $e->getMessage();
}
// Send confirmation email
$recipient = $email;
$subject = 'Welcome to Camagru. Confirm your email address';
$headers = array(
	'From' => 'jukkacamagru@outlook.com',
	'Reply-To' => 'jukkacamagru@outlook.com',
	'X-Mailer' => 'PHP/' . phpversion(),
	'Content-Type' => 'text/html'
);
if (isset($_SERVER['HTTP_HOST']))
	$domain = $_SERVER['HTTP_HOST'];
else
	$domain = 'localhost';

if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80')
	$port = $_SERVER['SERVER_PORT'];
else
	$port = '';
ob_start();
include('../components/confirmation_email.php');
$message = ob_get_contents();
ob_end_clean();
mail($recipient, $subject, $message, $headers);

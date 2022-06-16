<?php
require_once "../classes/dbh.class.php";

if (!isset($_POST['username']) || !isset($_POST['email']))
	return "Invalid parameters";

$username = $_POST['username'];
$recipient = $_POST['email'];

try {

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT * FROM users WHERE username = ?;");
	$statement->execute([$username]);
	$userinfo = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$userinfo) {
		return;
	}
	if ($userinfo['email'] != $recipient)
		return;
	$password_reset_key = base64_encode(uniqid(rand(), true));
	$subject = 'Confirm password reset for your Camagru account';
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
	include('../components/password_reset_email.php');
	$message = ob_get_contents();
	ob_end_clean();
	$statement = $pdo->prepare("UPDATE users SET `password_reset_key` = ? WHERE `username` = ? AND `email` = ?;");
	$statement->execute([$password_reset_key, $username, $recipient]);
	mail($recipient, $subject, $message, $headers);
} catch (Exception $e) {
	echo $e->getMessage();
}

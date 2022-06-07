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
	$validation_key = base64_encode(uniqid(rand(), true));
	$recipient = 'jukkacamagru@outlook.com';
	$subject = 'Welcome to Camagru. Confirm your email address';
	$headers = array(
		'From' => 'jukka.ylimaula@gmail.com',
		'Reply-To' => 'jukka.ylimaula@gmail.com',
		'X-Mailer' => 'PHP/' . phpversion(),
		'Content-Type' => 'text/html'
	);
	$message = '
		
		<h1>Welcome to Camagru</h1>
		<p>For the last step of registration we ask you to click the link below to validate this email address.</p>
		<p><a href="http://localhost:8080/confirm?validation_key=' . $validation_key . '">http://localhost:8080/confirm?validation_key=' . $validation_key . '</a></p>
	';
	mail($recipient, $subject, $message, $headers);
	$statement = $pdo->prepare("INSERT INTO users (`name`, username, `password`, email, validation_key) VALUES (?, ?, ?, ?, ?);");
	$statement->execute([
		$name,
		$username,
		password_hash($password, PASSWORD_ARGON2ID),
		$email,
		$validation_key
	]);
	header("Location: /confirm");
	return;

}
catch (PDOException $pe) {
	echo $pe->getMessage();
}
?>
<h1>Welcome to Camagru</h1>
<p>For the last step of registration we'd ask you to click the link below to validate this email address.</p>
<p><a href="localhost:8080/confirm?validation_key=">localhost:8080/confirm?validation_key=</a></p>
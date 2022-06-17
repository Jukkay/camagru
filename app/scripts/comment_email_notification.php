<?php

$statement = $pdo->prepare("SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE posts.post_id = ?;");
$statement->execute([$post_id]);
$post = $statement->fetch(PDO::FETCH_ASSOC);
if (!$post) {
	return;
}
$email_notification = $post['email_notification'];
if (!$email_notification)
	return;
$recipient = $post['email'];
$comments = $post['comments'];
$subject = 'Somebody commented your post in Camagru!';
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

if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443')
	$port = $_SERVER['SERVER_PORT'];
else
	$port = '';
ob_start();
include('../components/comment_notification.php');
$message = ob_get_contents();
ob_end_clean();
mail($recipient, $subject, $message, $headers);

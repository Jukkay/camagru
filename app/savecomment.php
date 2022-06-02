<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['user_id']) ||
		empty($_POST['post_id']) ||
		empty($_POST['comment']) ||
		$_POST['user_id'] == '0' ||
		$_POST['user_id'] != $_SESSION['user_id'])
		return;
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$comment = htmlspecialchars($_POST['comment']);
	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO comments (post_id, `user_id`, comment) VALUES ( ?, ?, ?);");
	$statement->execute([$post_id, $user_id, $comment]);
	$statement = $pdo->prepare("UPDATE posts SET comments = comments + 1 WHERE post_id = ? AND `user_id` = ?;");
	$statement->execute([$post_id, $user_id]);
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

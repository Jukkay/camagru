<?php
session_start();
require_once "../classes/dbh.class.php";

try {
	if (
		!isset($_POST['user_id']) ||
		!isset($_POST['post_id']) ||
		!isset($_SESSION['username']) ||
		$_POST['user_id'] == '0' ||
		$_POST['user_id'] != $_SESSION['user_id']
	)
		return;
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$username = $_SESSION['username'];

	$dbh = new Dbh;
	$pdo = $dbh->connect();

	$statement = $pdo->prepare("INSERT INTO likes (post_id, `user_id`) VALUES ( ?, ?);");
	$statement->bindParam(1, $post_id, PDO::PARAM_INT);
	$statement->bindParam(2, $user_id, PDO::PARAM_INT);
	$statement->execute();
	$statement = $pdo->prepare("UPDATE posts SET likes = likes + 1 WHERE post_id = ?;");
	$statement->bindParam(1, $post_id, PDO::PARAM_INT);
	$statement->execute();
	include 'like_email_notification.php';
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

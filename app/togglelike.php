<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['user_id']) ||
		empty($_POST['post_id']) ||
		$_POST['user_id'] == '0' ||
		$_POST['user_id'] != $_SESSION['user_id'])
		return;
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND `user_id` = ?;");
	$statement->bindParam(1, $post_id, PDO::PARAM_INT);
	$statement->bindParam(2, $user_id, PDO::PARAM_INT);
	$statement->execute();
	$like = $statement->fetchAll(PDO::FETCH_ASSOC);
	if ($like) {
		$statement = $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND `user_id` = ?;");
		$statement->bindParam(1, $post_id, PDO::PARAM_INT);
		$statement->bindParam(2, $user_id, PDO::PARAM_INT);
		$statement->execute();
		$statement = $pdo->prepare("UPDATE posts SET likes = likes - 1 WHERE post_id = ?;");
		$statement->bindParam(1, $post_id, PDO::PARAM_INT);
		$statement->execute();
	}
	else {
		$statement = $pdo->prepare("INSERT INTO likes (post_id, `user_id`) VALUES ( ?, ?);");
		$statement->bindParam(1, $post_id, PDO::PARAM_INT);
		$statement->bindParam(2, $user_id, PDO::PARAM_INT);
		$statement->execute();
		$statement = $pdo->prepare("UPDATE posts SET likes = likes + 1 WHERE post_id = ?;");
		$statement->bindParam(1, $post_id, PDO::PARAM_INT);
		$statement->execute();
	}
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

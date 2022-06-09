<?php
session_start();
require_once "../classes/dbh.class.php";

try {
	if (!isset($_POST['post_id']) || !isset($_POST['user_id']) || !isset($_POST['image_file']) || $_POST['user_id'] == '0' || $_POST['user_id'] != $_SESSION['user_id'])
		return;
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$filename = $_POST['image_file'];
	unlink('../img/' . $filename);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("DELETE FROM posts WHERE post_id = ? AND `user_id`= ?");
	$statement->execute([$post_id, $user_id]);
	$statement = $pdo->prepare("DELETE FROM comments WHERE post_id = ?");
	$statement->execute([$post_id]);
	$statement = $pdo->prepare("DELETE FROM likes WHERE post_id = ?");
	$statement->execute([$post_id]);
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
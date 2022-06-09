<?php
session_start();
require_once "../classes/dbh.class.php";

try {
	if (!isset($_POST['post_id']) || !isset($_POST['user_id']) || $_POST['user_id'] == '0' || $_POST['user_id'] != $_SESSION['user_id'])
		return;
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("DELETE FROM posts WHERE post_id = ? AND `user_id`= ?");
	$statement->execute([$post_id, $user_id]);
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
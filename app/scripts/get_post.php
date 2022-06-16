<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_GET['post_id']))
	return "Invalid parameters";

$post_id = $_GET['post_id'];
if (isset($_SESSION['user_id']))
	$user_id = $_SESSION['user_id'];
else
	$user_id = 0;
try {

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE posts.post_id = ?;");
	$statement->execute([$post_id]);
	$post = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$post) {
		return;
	}
	$statement = $pdo->prepare("SELECT posts.post_id FROM posts INNER JOIN likes ON posts.post_id = likes.post_id AND likes.user_id = ?;");
	$statement->bindParam(1, $user_id, PDO::PARAM_INT);
	$statement->execute();
	$likes = $statement->fetchAll(PDO::FETCH_ASSOC);

	function check_likes ($likes, $post_id) {
		foreach($likes as $key => $value) {
			if ($value['post_id'] == $post_id)
			return true;
		}
		return false;
	}

	require "../components/post.php";
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}

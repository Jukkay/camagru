<?php
session_start();
require_once "../classes/dbh.class.php";

if (
	!isset($_POST['user_id']) ||
	!isset($_POST['post_id']) ||
	!isset($_POST['comment']) ||
	!isset($_SESSION['username']) ||
	$_POST['user_id'] == '0' ||
	$_POST['user_id'] != $_SESSION['user_id']
)
	return;

try {
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$username = $_SESSION['username'];
	$comment = htmlspecialchars($_POST['comment']);
	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO comments (post_id, `user_id`, comment) VALUES ( ?, ?, ?);");
	$statement->execute([$post_id, $user_id, $comment]);
	$statement = $pdo->prepare("UPDATE posts SET comments = (SELECT COUNT(*) FROM comments WHERE post_id = ?) WHERE post_id = ?;");
	$statement->execute([$post_id, $post_id]);
	include 'comment_email_notification.php';
	$statement = $pdo->prepare("SELECT * FROM comments INNER JOIN users ON users.user_id = comments.user_id WHERE post_id = ? ORDER BY comment_date;");
	$statement->execute([$post_id]);
	$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

	if (!$comments) {
		return;
	}

	foreach ($comments as $comment) {
		include "../components/comment_line.php";
	}
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}


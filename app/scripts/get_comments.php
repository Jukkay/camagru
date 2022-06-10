<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_GET['post_id']))
	return "Invalid parameters";
$post_id = $_GET['post_id'];

$dbh = new Dbh;
$pdo = $dbh->connect();
$statement = $pdo->prepare("SELECT * FROM comments INNER JOIN users ON users.user_id = comments.user_id WHERE post_id = ? ORDER BY comment_date;");
$statement->bindParam(1, $post_id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
if (!$comments) {
	return;
}

foreach($comments as $comment) {
	include "../components/comment_line.php";
}


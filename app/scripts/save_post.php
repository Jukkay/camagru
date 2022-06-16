<?php
session_start();
require_once "../classes/dbh.class.php";

if (
	empty($_POST['image']) ||
	empty($_POST['description']) ||
	empty($_POST['user_id']) ||
	$_POST['user_id'] == '0' ||
	$_POST['user_id'] != $_SESSION['user_id']
)
	return;

$image = $_POST['image'];
$user_id = $_POST['user_id'];
$description = htmlspecialchars($_POST['description']);
$path = "../img/";
$filename = $path . $image;
if (!file_exists($path . $image))
	return;

try {
	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO posts (`user_id`, image_file, `description`) VALUES ( ?, ?, ?);");
	$statement->execute([$user_id, $image, $description]);
	$statement = $pdo->prepare("DELETE FROM drafts WHERE image_file = ? AND `user_id` = ?");
	$statement->execute([$image, $user_id]);
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

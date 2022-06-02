<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['img']) || $_POST['user_id'] == '0' || $_POST['user_id'] != $_SESSION['user_id'])
		throw new Exception('Invalid input');

	$filename = "../img/" . $_POST['img'];
	unlink($filename);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("DELETE FROM drafts WHERE image_file=? AND `user_id`=?");
	$statement->execute([$_POST['img'], $_POST['user_id']]);
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
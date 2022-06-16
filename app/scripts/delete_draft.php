<?php
session_start();
require_once "../classes/dbh.class.php";

try {
	if (empty($_POST['img']) || $_POST['user_id'] == '0' || $_POST['user_id'] != $_SESSION['user_id'])
		return;

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("DELETE FROM drafts WHERE image_file=? AND `user_id`=?");
	$statement->execute([$_POST['img'], $_POST['user_id']]);
	$filename = "../img/" . $_POST['img'];
	unlink($filename);
	}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
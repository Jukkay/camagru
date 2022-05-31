<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['img']) || $_POST['uid'] == '0' || $_POST['uid'] != $_SESSION['uid'])
		throw new Exception('Invalid input');

	$filename = "../img/" . $_POST['img'];
	unlink($filename);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("DELETE FROM editor WHERE img=? AND uid=?");
	$statement->execute([$_POST['img'], $_POST['uid']]);
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
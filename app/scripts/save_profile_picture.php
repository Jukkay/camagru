<?php
session_start();
require_once "../classes/dbh.class.php";

try {
	if (empty($_POST['img']) || $_POST['user_id'] == '0' || $_POST['user_id'] != $_SESSION['user_id'])
		return;
	$imagedata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['img']));
	$filename = uniqid(rand(), true) . '.png';
	$path = "../img/";
	file_put_contents($path . $filename, $imagedata);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("SELECT profile_image FROM users WHERE `user_id` = ?;");
	$statement->execute([$_POST['user_id']]);
	$oldimage = $statement->fetch(PDO::FETCH_ASSOC);
	$oldimage = "../img/" . $oldimage['profile_image'];
	unlink($oldimage);
	$statement = $pdo->prepare("UPDATE users SET profile_image = ? WHERE `user_id` = ?;");
	$statement->execute([$filename, $_POST['user_id']]);
	$_SESSION['profile_image'] = $filename;
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['sticker']) || empty($_POST['img']) || $_POST['uid'] == '0' || $_POST['uid'] != $_SESSION['uid'])
		return;
	$base = base64_decode($_POST['img']);
	$sticker = '../public/assets/stickers/' . $_POST['sticker'];
	$s_size = getimagesize($sticker);
	// $b_size = getimagesizefromstring($base);
	$filename = uniqid(rand(), true) . '.png';
	$path = "../img/";
	$base = imagecreatefromstring($base);
	$sticker = imagecreatefrompng($sticker);

	imagecopy($base, $sticker, 0, 0, 0, 0, $s_size[0], $s_size[1]);
	imagepng($base, $path . $filename);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO editor (img, `uid`, sticker) VALUES ( ?, ?, ?);");
	$statement->execute([$filename, $_POST['uid'], $_POST['sticker']]);

	imagedestroy($base);
	imagedestroy($sticker);
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
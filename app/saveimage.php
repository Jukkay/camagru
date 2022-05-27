<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['stickers']) || empty($_POST['img']) || $_POST['uid'] == '0' || $_POST['uid'] != $_SESSION['uid'])
		return;
	$base = base64_decode($_POST['img']);
	$filename = uniqid(rand(), true) . '.png';
	$path = "../img/";
	$base = imagecreatefromstring($base);
	$stickers = $_POST['stickers'];
	foreach($stickers as $sticker) {
		$sticker = explode(',', $sticker);
		$sticker = base64_decode($sticker[0]);
		$sticker = imagecreatefromstring($sticker);
		$s_width = imagesx($sticker);
		$s_height = imagesy($sticker);
		imagecopy($base, $sticker, 0, 0, 0, 0, $s_width, $s_height);
		imagedestroy($sticker);
	}
	imagepng($base, $path . $filename);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO editor (img, `uid`) VALUES ( ?, ?);");
	$statement->execute([$filename, $_POST['uid']]);
	imagedestroy($base);
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
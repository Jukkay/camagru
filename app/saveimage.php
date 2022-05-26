<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['stickers']) || empty($_POST['img']) || $_POST['uid'] == '0' || $_POST['uid'] != $_SESSION['uid'])
		return;
	$base = base64_decode($_POST['img']);
	// $b_size = getimagesizefromstring($base);
	$filename = uniqid(rand(), true) . '.png';
	$path = "../img/";
	$base = imagecreatefromstring($base);
	foreach($_POST['stickers'] as $sticker) {
		$sticker = imagecreatefrompng($sticker);
		imagecopy($base, $sticker, 0, 0, 0, 0, $s_size[0], $s_size[1]);
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
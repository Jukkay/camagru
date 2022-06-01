<?php
session_start();
require_once "classes/dbh.class.php";

try {
	if (empty($_POST['img']) || $_POST['uid'] == '0' || $_POST['uid'] != $_SESSION['user_id'])
		return;
	$base = base64_decode($_POST['img']);
	$filename = uniqid(rand(), true) . '.png';
	$path = "../img/";
	$base = imagecreatefromstring($base);
	if (isset($_POST['stickers'])) {
		$stickers = $_POST['stickers'];
		foreach($stickers as $sticker) {

			$sticker = explode(',', $sticker);
			$dst_x = (int)$sticker[2];
			$dst_y = (int)$sticker[3];
			$sticker = base64_decode($sticker[0]);
			$sticker = imagecreatefromstring($sticker);
			$src_w = imagesx($sticker);
			$src_h = imagesy($sticker);
			imagecopy($base, $sticker, $dst_x, $dst_y, 0, 0, $src_w, $src_h);
			imagedestroy($sticker);
		}
	}
	imagepng($base, $path . $filename);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO drafts (image_file, `user_id`) VALUES ( ?, ?);");
	$statement->execute([$filename, $_POST['uid']]);
	imagedestroy($base);
	echo $filename;
}
catch(Exception $e) {
	echo 'Error: ' .$e->getMessage();
}
<?php
session_start();
require_once "../classes/dbh.class.php";

if (
	empty($_POST['img']) ||
	$_POST['user_id'] == '0' ||
	$_POST['user_id'] != $_SESSION['user_id']
)
	return;

try {
	$base = base64_decode($_POST['img']);
	$filename = uniqid(rand(), true) . '.png';
	$path = "../img/";
	$base = imagecreatefromstring($base);
	if (isset($_POST['stickers'])) {
		$stickers = $_POST['stickers'];
		foreach ($stickers as $sticker) {

			$sticker = explode(',', $sticker);
			$dst_x = (int)$sticker[2];
			$dst_y = (int)$sticker[3];
			$src_w = (int)$sticker[4];
			$src_h = (int)$sticker[5];
			$opacity = (int)$sticker[6];
			$sticker = base64_decode($sticker[0]);
			$sticker = imagecreatefromstring($sticker);
			$sticker = imagescale($sticker, $src_w, $src_h);
			$canvas = imagecreatetruecolor($src_w, $src_h);
			imagecopy($canvas, $base, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
			imagecopy($canvas, $sticker, 0, 0, 0, 0, $src_w, $src_h);
			imagecopymerge($base, $canvas, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $opacity);
			imagedestroy($sticker);
			imagedestroy($canvas);
		}
	}
	imagepng($base, $path . $filename);

	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("INSERT INTO drafts (image_file, `user_id`) VALUES ( ?, ?);");
	$statement->execute([$filename, $_POST['user_id']]);
	imagedestroy($base);
	echo $filename;
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

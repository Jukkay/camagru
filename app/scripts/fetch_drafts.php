<?php
require_once "../classes/dbh.class.php";

if (!isset($_GET['user_id']))
	return;
echo '<h2 class="subtitle">Drafts</h2>';

try {

	$dbh = new Dbh;
	$pdo = $dbh->connect();

	$statement = $pdo->prepare("SELECT * FROM drafts WHERE `user_id` = ?;");
	$statement->execute([$_GET['user_id']]);
	$images = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo $e->getMessage();
}

if (!$images) {
	return;
}
foreach($images as $image) {
	include "../components/draft.php";
}
<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_GET['user_id']) || $_GET['user_id'] == 0 || $_GET['user_id'] != $_SESSION['user_id'])
	return "Invalid input";

$user_id = $_GET['user_id'];
$dbh = new Dbh;
$pdo = $dbh->connect();
$statement = $pdo->prepare("SELECT * FROM users WHERE `user_id` = ?;");
$statement->execute([$user_id]);
$userinfo = $statement->fetch(PDO::FETCH_ASSOC);

if (!$userinfo) {
	echo "No user found" . PHP_EOL;
	return ;
}
include "../components/configuration_form.php";
?>
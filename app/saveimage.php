<?php
session_start();
require_once "classes/dbh.class.php";
// header('Content-Type: application/json; charset=utf-8');
if (empty($_POST['img']) || empty($_POST['uid']) || $_POST['uid'] != $_SESSION['uid'])
	return;
list($type, $data) = explode(';', $_POST['img']);
list(, $data) = explode(',', $data);
$data = base64_decode($data);
$filename = uniqid(rand(), true) . '.png';
$path = "../img/";
file_put_contents($path . $filename, $data);

$dbh = new Dbh;
$pdo = $dbh->connect();

$statement = $pdo->prepare("INSERT INTO editor (img, `uid`, sticker) VALUES ( ?, ?, ?);");
$statement->execute([$filename, $_POST['uid'], $_POST['sticker']]);
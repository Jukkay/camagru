<?php

require_once "../classes/dbh.class.php";

$validation_key = $_GET['validation_key'];
try {
	$dbh = new Dbh;
	$pdo = $dbh->connect();
	$statement = $pdo->prepare("UPDATE users SET validated = ? WHERE validation_key = ?;");
	$statement->execute(['1', $validation_key]);
} catch (Exception $e) {
	echo $e->getMessage();
}

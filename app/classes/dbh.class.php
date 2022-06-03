<?php

require_once "../config/database.php";

class Dbh extends Database{

	private $dsn;
	private $user;
	private $pwd;

	public function connect() {

		try {
			$pdo = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASSWORD);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		catch (PDOException $pe) {
			echo $pe->getMessage();
		}

	}

}

<?php

$DB_NAME = 'camagru';
$DB_USER = 'camagru';
$DB_PASSWORD = rtrim(file_get_contents("/run/secrets/mysql_password"));
$HOSTNAME = 'mariadb';
$DB_DSN = 'mysql:host=' . $HOSTNAME . ';dbname=' . $DB_NAME . ';charset=UTF8';

class Database {
	protected $DB_NAME = 'camagru';
	protected $DB_USER = 'camagru';
	protected $DB_PASSWORD;
	protected $HOSTNAME = 'mariadb';
	protected $DB_DSN;

	public function __construct () {
		$this->DB_PASSWORD = rtrim(file_get_contents("/run/secrets/mysql_password"));
		$this->DB_DSN = 'mysql:host=' . $this->HOSTNAME . ';dbname=' . $this->DB_NAME;
	}
}


<?php

require 'database.php';

try {
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// create tables
	$tables = [
		'DROP TABLE IF EXISTS users;',
		'CREATE TABLE users(
		`uid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		username VARCHAR(32) NOT NULL,
		`password` VARCHAR(255) NOT NULL,
		`name` VARCHAR(255) DEFAULT username,
		email VARCHAR(320) NOT NULL,
		img VARCHAR(255) DEFAULT "../img/default.png",
		validated BOOLEAN,
		`admin` BOOLEAN,
		joindate DATETIME DEFAULT CURRENT_TIMESTAMP,
		lastlogin DATETIME DEFAULT 0,
		lastlogout DATETIME DEFAULT 0,
		PRIMARY KEY (uid)
	);',
		'DROP TABLE IF EXISTS posts;',
		'CREATE TABLE posts(
		pid BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		img VARCHAR(1024),
		ptext VARCHAR(4096),
		likes INT UNSIGNED,
		comments INT UNSIGNED,
		created DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (pid)
	);',
		'DROP TABLE IF EXISTS editor;',
		'CREATE TABLE editor(
		eid BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		img VARCHAR(1024),
		`uid` INT(10) UNSIGNED NOT NULL,
		sticker INT(10) UNSIGNED,
		PRIMARY KEY (eid)
	);',
		'DROP TABLE IF EXISTS comments;',
		'CREATE TABLE comments(
		cid BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		pid BIGINT(10) UNSIGNED NOT NULL,
		`uid` INT(10) UNSIGNED NOT NULL,
		ctext VARCHAR(4096),
		created DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (cid)
	);',
		'DROP TABLE IF EXISTS likes;',
		'CREATE TABLE likes(
			pid BIGINT(10) UNSIGNED NOT NULL,
			`uid` INT(10) UNSIGNED NOT NULL,
			created DATETIME DEFAULT CURRENT_TIMESTAMP
	);'];
	foreach ($tables as $table) {
		$dbh->exec($table);
	}
	echo 'Database created successfully' . PHP_EOL;
}
catch (PDOException $pe) {
	echo $pe->getMessage();
}

// docker exec camagru-php-fpm-1 php -f /app/config/setup.php
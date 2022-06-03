<?php

require 'database.php';

try {
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// create tables
	$tables = [
		'DROP TABLE IF EXISTS users;',
		'CREATE TABLE users(
		`user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		username VARCHAR(32) NOT NULL,
		`password` VARCHAR(255) NOT NULL,
		`name` VARCHAR(255) DEFAULT username,
		email VARCHAR(320) NOT NULL,
		profile_image VARCHAR(255) DEFAULT "default.png",
		biography VARCHAR(4096),
		validation_date BOOLEAN,
		`admin` BOOLEAN,
		email_notification BOOLEAN,
		join_date DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`user_id`)
	);',
		'DROP TABLE IF EXISTS posts;',
		'CREATE TABLE posts(
		post_id BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`user_id` INT(10) UNSIGNED NOT NULL,
		image_file VARCHAR(1024),
		`description` VARCHAR(4096),
		likes INT UNSIGNED DEFAULT 0,
		comments INT UNSIGNED DEFAULT 0,
		creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (post_id)
	);',
		'DROP TABLE IF EXISTS drafts;',
		'CREATE TABLE drafts(
		draft_id BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		image_file VARCHAR(1024),
		`user_id` INT(10) UNSIGNED NOT NULL,
		PRIMARY KEY (draft_id)
	);',
		'DROP TABLE IF EXISTS comments;',
		'CREATE TABLE comments(
		comment_id BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		post_id BIGINT(10) UNSIGNED NOT NULL,
		`user_id` INT(10) UNSIGNED NOT NULL,
		comment VARCHAR(4096),
		comment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (comment_id)
	);',
		'DROP TABLE IF EXISTS likes;',
		'CREATE TABLE likes(
		like_id BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		post_id BIGINT(10) UNSIGNED NOT NULL,
		`user_id` INT(10) UNSIGNED NOT NULL,
		like_date DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (like_id)
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
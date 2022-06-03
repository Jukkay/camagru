<?php

spl_autoload_register('autoloader');

function autoloader($className) {

	$path = 'classes/';
	$ext = '.class.php';
	$className = strtolower($className);
	$incFile = $path . $className . $ext;

	if (!file_exists($incFile)) {
		return false;
	}
	include_once $incFile;
}
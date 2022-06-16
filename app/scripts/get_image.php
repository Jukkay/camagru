<?php
$filename = trim($_GET['name'], '/');
if ($filename == '')
	return;
$filename = '../img/' . $filename;
if (file_exists($filename)) {
	header("Content-type: image/png");
	readfile($filename);
} else
	echo "file not found";

<?php

$filename = '../img/' . $_GET['name'];
if(file_exists($filename)) {
	header("Content-type: image/png");
	readfile($filename);
}
else
	echo "file not found";
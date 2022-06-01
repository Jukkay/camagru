<?php

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch ($request) {
	case '':
	case '/':
		require '../header.php';
		require '../feed.php';
		require '../footer.php';
		break;
	case '/signup':
		require '../header.php';
		require '../signup.php';
		require '../footer.php';
		break;
	case '/process_signup':
		require '../header.php';
		require '../includes/signup.inc.php';
		require '../footer.php';
		break;
	case '/login':
		require '../header.php';
		require '../login.php';
		require '../footer.php';
		break;
	case '/process_login':
		require '../header.php';
		require '../includes/login.inc.php';
		require '../footer.php';
		break;
	case '/logout':
		require '../header.php';
		require '../logout.php';
		require '../footer.php';
		break;
	case '/profile':
		require '../header.php';
		require '../profile.php';
		require '../footer.php';
		break;
	case '/camera':
		require '../header.php';
		require '../camera.php';
		require '../footer.php';
		break;
	case '/fetcheditor':
		require '../fetcheditor.php';
		break;
	case '/fetchfeed':
		require '../fetchfeed.php';
		break;
	case '/saveimage':
		require '../saveimage.php';
		break;
	case '/getimage':
		require '../getimage.php';
		break;
	case '/deleteimage':
		require '../deleteimage.php';
		break;
	case '/newpost':
		require '../header.php';
		require '../newpost.php';
		require '../footer.php';
		break;
	case '/savepost':
		require '../savepost.php';
		break;
	default:
		http_response_code(404);
		require '../header.php';
		require '404.php';
		require '../footer.php';
}
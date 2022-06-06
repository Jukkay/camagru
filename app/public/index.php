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
	case '/fetchdrafts':
		require '../fetchdrafts.php';
		break;
	case '/fetchfeed':
		require '../fetchfeed.php';
		break;
	case '/savedraft':
		require '../savedraft.php';
		break;
	case '/getimage':
		require '../getimage.php';
		break;
	case '/deletedraft':
		require '../deletedraft.php';
		break;
	case '/newpost':
		require '../header.php';
		require '../newpost.php';
		require '../footer.php';
		break;
	case '/savepost':
		require '../savepost.php';
		break;
	case '/savecomment':
		require '../savecomment.php';
		break;
	case '/getcomments':
		require '../getcomments.php';
		break;
	case '/togglelike':
		require '../togglelike.php';
		break;
	case '/getuserinfo':
		require '../getuserinfo.php';
		break;
	case '/getuserimages':
		require '../getuserimages.php';
		break;
	case '/controlpanel':
		require '../header.php';
		require '../controlpanel.php';
		require '../footer.php';
		break;
	case '/getuserconfiguration':
		require '../getuserconfiguration.php';
		break;
	case '/saveuserconfiguration':
		require '../saveuserconfiguration.php';
		break;
	case '/saveprofilepicture':
		require '../saveprofilepicture.php';
		break;
	case '/updatepassword':
		require '../header.php';
		require '../changepassword.php';
		require '../footer.php';
		break;
	case '/processpassword':
		require '../processpassword.php';
		break;
	default:
		http_response_code(404);
		require '404.php';

}
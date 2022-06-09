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
		require '../scripts/signup_processing.php';
		break;
	case '/checkusername':
		require '../checkuser.php';
		break;
	case '/checkemail':
		require '../checkemail.php';
		break;
	case '/login':
		require '../header.php';
		require '../login.php';
		require '../footer.php';
		break;
	case '/process_login':
		require '../scripts/login_processing.php';
		break;
	case '/logout':
		require '../logout.php';
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
	case '/showpost':
		require '../header.php';
		require '../showpost.php';
		require '../footer.php';
		break;
	case '/fetchpost':
		require '../scripts/get_post.php';
		break;
	case '/savepost':
		require '../savepost.php';
		break;
	case '/savecomment':
		require '../scripts/save_comment.php';
		break;
	case '/getcomments':
		require '../getcomments.php';
		break;
	case '/togglelike':
		require '../scripts/toggle_like.php';
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
		require '../scripts/reset_password.php';
		break;
	case '/confirm':
		require '../header.php';
		require '../validateuser.php';
		require '../footer.php';
		break;
	case '/resetpassword':
		require '../header.php';
		require '../resetpassword.php';
		require '../footer.php';
		break;
	case '/resetkey':
		require '../scripts/send_password_reset_key.php';
		break;
	case '/emailpasswordreset':
		require '../header.php';
		require '../emailpasswordreset.php';
		require '../footer.php';
		break;
	case '/processpasswordreset':
		require '../scripts/reset_password_with_key.php';
		break;
	case '/deletepost':
		require '../scripts/delete_post.php';
		break;
	default:
		http_response_code(404);
		require '404.php';

}
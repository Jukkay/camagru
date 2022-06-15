<?php

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch ($request) {

		// Pages

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
	case '/login':
		require '../header.php';
		require '../login.php';
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
	case '/controlpanel':
		require '../header.php';
		require '../controlpanel.php';
		require '../footer.php';
		break;
	case '/updatepassword':
		require '../header.php';
		require '../changepassword.php';
		require '../footer.php';
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
	case '/emailpasswordreset':
		require '../header.php';
		require '../emailpasswordreset.php';
		require '../footer.php';
		break;

		// Scripts

	case '/process_signup':
		require '../scripts/signup_processing.php';
		break;
	case '/checkusername':
		require '../scripts/check_user.php';
		break;
	case '/checkemail':
		require '../scripts/check_email.php';
		break;
	case '/process_login':
		require '../scripts/login_processing.php';
		break;
	case '/logout':
		require '../scripts/logout.php';
		break;
	case '/fetchdrafts':
		require '../scripts/fetch_drafts.php';
		break;
	case '/fetchfeed':
		require '../scripts/fetch_feed.php';
		break;
	case '/savedraft':
		require '../scripts/save_draft.php';
		break;
	case '/getimage':
		require '../scripts/get_image.php';
		break;
	case '/deletedraft':
		require '../scripts/delete_draft.php';
		break;
	case '/fetchpost':
		require '../scripts/get_post.php';
		break;
	case '/savepost':
		require '../scripts/save_post.php';
		break;
	case '/savecomment':
		require '../scripts/save_comment.php';
		break;
	case '/getcomments':
		require '../scripts/get_comments.php';
		break;
	case '/likepost':
		require '../scripts/like_post.php';
		break;
	case '/unlikepost':
		require '../scripts/unlike_post.php';
		break;
	case '/getuserinfo':
		require '../scripts/get_profile_information.php';
		break;
	case '/getuserimages':
		require '../scripts/get_user_images.php';
		break;
	case '/getuserconfiguration':
		require '../scripts/get_user_configuration.php';
		break;
	case '/saveuserconfiguration':
		require '../scripts/save_user_configuration.php';
		break;
	case '/saveprofilepicture':
		require '../scripts/save_profile_picture.php';
		break;
	case '/processpassword':
		require '../scripts/reset_password.php';
		break;
	case '/resetkey':
		require '../scripts/send_password_reset_key.php';
		break;
	case '/processpasswordreset':
		require '../scripts/reset_password_with_key.php';
		break;
	case '/deletepost':
		require '../scripts/delete_post.php';
		break;
	case '/phpinfo':
		require '../scripts/phpinfo.php';
		break;
	default:
		http_response_code(404);
		require '404.php';
}

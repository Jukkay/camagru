<?php
session_start();
require_once "classes/dbh.class.php";

if (!isset($_GET['user_id']) || $_GET['user_id'] == 0 || $_GET['user_id'] != $_SESSION['user_id'])
	return "Invalid input";

$user_id = $_GET['user_id'];
$dbh = new Dbh;
$pdo = $dbh->connect();
$statement = $pdo->prepare("SELECT * FROM users WHERE `user_id` = ?;");
$statement->execute([$user_id]);
$userinfo = $statement->fetch(PDO::FETCH_ASSOC);

if (!$userinfo) {
	echo "No user found" . PHP_EOL;
	return ;
}
?>
<section class="section">
	<div class="field">
		<label class="label">Profile picture</label>
		<figure class="image is-256x256">
			<img src="/getimage?name=<?php echo $userinfo['profile_image'] ?>" alt="Profile Picture">
		</figure>
	</div>
	<div class="field">
		<input type="file" id="image-input" accept="image/png" hidden>
		<button class="button" id="upload">
			<span class="icon is-small">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
					<path fill="currentColor" d="M22 8V13.81C21.39 13.46 20.72 13.22 20 13.09V8H4V18H13.09C13.04 18.33 13 18.66 13 19C13 19.34 13.04 19.67 13.09 20H4C2.9 20 2 19.11 2 18V6C2 4.89 2.89 4 4 4H10L12 6H20C21.1 6 22 6.89 22 8M16 18H18V22H20V18H22L19 15L16 18Z" />
				</svg>
			</span>
			<span>Upload picture</span>
		</button>
	</div>
	<form action="/saveuserconfiguration" method="post">
	<div class="field">
		<label class="label">Name</label>
		<div class="control">
			<input class="input" type="text" name="name" value="<?php echo $userinfo['name']; ?>">
		</div>
	</div>
	<div class="field">
		<label class="label">Biography</label>
		<div class="control">
			<textarea class="textarea block" name="biography"><?php echo $userinfo['biography']; ?></textarea>
		</div>
	</div>
	<div class="field">
		<label class="label">Username</label>
		<div class="control has-icons-left has-icons-right">
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "usernametaken") {
					echo '<input class="input is-danger" type="text" name="username" value="' . $userinfo['username'] . '"  minlength="3" maxlength="32">';
				}
				else {
					echo '<input class="input" type="text" name="username"  value="' . $userinfo['username'] . '" minlength="3" maxlength="32">';
				}
			?>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
				</svg>
			</span>
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "usernametaken") {
					echo '<p class="help is-danger">This username is not available. Try another one.</p>';
				}
			?>
		</div>
	</div>
	<div class="field">
		<label class="label">Email</label>
		<div class="control has-icons-left has-icons-right">
			<?php
				if (isset($_GET['error']) && ($_GET['error'] == "emailtaken" || $_GET['error'] == "invalidemail")) {
					echo '<input class="input is-danger" type="email" name="email" value="' . $userinfo['email'] . '"  maxlength="320">';
				}
				else {
					echo '<input class="input" type="email" name="email" value="' . $userinfo['email'] . '" maxlength="320">';
				}
			?>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,15C12.81,15 13.5,14.7 14.11,14.11C14.7,13.5 15,12.81 15,12C15,11.19 14.7,10.5 14.11,9.89C13.5,9.3 12.81,9 12,9C11.19,9 10.5,9.3 9.89,9.89C9.3,10.5 9,11.19 9,12C9,12.81 9.3,13.5 9.89,14.11C10.5,14.7 11.19,15 12,15M12,2C14.75,2 17.1,3 19.05,4.95C21,6.9 22,9.25 22,12V13.45C22,14.45 21.65,15.3 21,16C20.3,16.67 19.5,17 18.5,17C17.3,17 16.31,16.5 15.56,15.5C14.56,16.5 13.38,17 12,17C10.63,17 9.45,16.5 8.46,15.54C7.5,14.55 7,13.38 7,12C7,10.63 7.5,9.45 8.46,8.46C9.45,7.5 10.63,7 12,7C13.38,7 14.55,7.5 15.54,8.46C16.5,9.45 17,10.63 17,12V13.45C17,13.86 17.16,14.22 17.46,14.53C17.76,14.84 18.11,15 18.5,15C18.92,15 19.27,14.84 19.57,14.53C19.87,14.22 20,13.86 20,13.45V12C20,9.81 19.23,7.93 17.65,6.35C16.07,4.77 14.19,4 12,4C9.81,4 7.93,4.77 6.35,6.35C4.77,7.93 4,9.81 4,12C4,14.19 4.77,16.07 6.35,17.65C7.93,19.23 9.81,20 12,20H17V22H12C9.25,22 6.9,21 4.95,19.05C3,17.1 2,14.75 2,12C2,9.25 3,6.9 4.95,4.95C6.9,3 9.25,2 12,2Z" />
				</svg>
			</span>
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "emailtaken") {
					echo '<p class="help is-danger">This email address is associated with an existing account.</p>';
				}
				if (isset($_GET['error']) && $_GET['error'] == "invalidemail") {
					echo '<p class="help is-danger">Invalid email address.</p>';
				}
			?>
		</div>
	</div>

	<div class="field">
		<label class="label">Email preferences</label>
		<label class="checkbox">
			<input type="checkbox" name="email_notification" value="
			<?php echo $userinfo['email_notification'];?>"
			<?php if ($userinfo['email_notification'] == '1') echo ' checked';?>>Receive email notifications
		</label>
	</div>
	<div class="field">
		<label class="label">Password</label>
			<a class="button" href="updatepassword">Change password</a>

	</div>
	<div class="field is-grouped">
		<div class="control">
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
			<button class="button is-primary" type="submit" name="submit" value="OK">Save</button>
		</div>
		<div class="control">
			<a class="button is-light" href='/'>Cancel</a>
		</div>
	</div>
</section>
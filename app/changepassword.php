<form action="/processpassword" method="post">
	<div class="field">
		<label class="label">Old password</label>
		<div class="control has-icons-left has-icons-right">
		<?php
				if (isset($_GET['error']) && ($_GET['error'] == "missingoldpw" || $_GET['error'] == "oldpwmismatch")) {
					echo '<input class="input is-danger" type="password" name="oldpw" placeholder="Old password" minlength="8" maxlength="255">';
				}
				else {
					echo '<input class="input" type="password" name="oldpw" placeholder="Old password" minlength="8" maxlength="255">';
				}
			?>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "passwdempty") {
					echo '<p class="help is-danger">Password may not be empty.</p>';
				}
				else {
					echo '<p class="help">Minimum of 8 characters.</p>';
				}
			?>
		</div>
	</div>
	<div class="field">
		<label class="label">New password</label>
		<div class="control has-icons-left has-icons-right">
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "invalidpasswd") {
					echo '<input class="input is-danger" type="password" name="passwd" placeholder="Password" minlength="8" maxlength="255">';
				}
				else {
					echo '<input class="input" type="password" name="passwd" placeholder="Password" minlength="8" maxlength="255">';
				}
			?>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "passwdempty") {
					echo '<p class="help is-danger">Password may not be empty.</p>';
				}
				else {
					echo '<p class="help">Minimum of 8 characters.</p>';
				}
			?>
		</div>
	</div>
	<div class="field">
		<label class="label">Confirm password</label>
		<div class="control has-icons-left has-icons-right">
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "passwdnotmatch") {
					echo '<input class="input is-danger" type="password" name="passwd2" placeholder="Password" minlength="8" maxlength="255">';
				}
				else {
					echo '<input class="input" type="password" name="passwd2" placeholder="Password" minlength="8" maxlength="255">';
				}
			?>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<?php
				if (isset($_GET['error']) && $_GET['error'] == "passwdnotmatch") {
					echo '<p class="help is-danger">Passwords do not match</p>';
				}
			?>
		</div>
	</div>
	<div class="field is-grouped">
		<div class="control">
			<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
			<button class="button is-primary" type="submit" name="submit" value="OK">Submit</button>
		</div>
		<div class="control">
			<a class="button is-light" href='/'>Cancel</a>
		</div>
	</div>
</form>

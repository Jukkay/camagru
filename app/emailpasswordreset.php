<?php
if (!isset($_GET['password_reset_key'])) {
	header("Location: /");
}
?>
<script> const password_reset_key = '<?php echo $_GET['password_reset_key']; ?>'; </script>
<script src="js/emailpasswordreset.js" defer></script>
<form id="emailresetform">
	<div class="field">
		<label class="label">New password *</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" type="password" id="password" name="password" placeholder="New password" minlength="8" maxlength="255" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
		</div>
	</div>

	<div class="field">
		<label class="label">Confirm password *</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" type="password" id="password2" name="password2" placeholder="Confirm password" minlength="8" maxlength="255" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<p id="nomatch" class="help is-danger is-hidden">Passwords don't match</p>
		</div>
	</div>
	<div class="field is-grouped">
		<div class="control">
			<button class="button is-primary" type="submit" name="submit" value="OK">Submit</button>
		</div>
		<div class="control">
			<a class="button is-light" href='/'>Cancel</a>
		</div>
	</div>
	<p class="help">All fields marked with asterisks (*) are required.</p>
	<div class="field">
		<p id="invalidkey" class="is-danger is-hidden">Invalid key. Try resetting again.</p>
	</div>
</form>

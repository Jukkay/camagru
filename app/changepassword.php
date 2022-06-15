
<script src="js/cppasswordreset.js" defer></script>
<section class="section">
<form id="resetform">
	<div class="field">
		<label class="label">Old password *</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" id="oldpassword" type="password" name="oldpassword" placeholder="Old password" minlength="8" maxlength="255" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<p id="invalidpassword" class="help is-danger is-hidden">Invalid password</p>
		</div>
	</div>
	<div class="field">
		<label class="label">New password *</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" id="password" type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" maxlength="255" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<p class="help">Minimum of 8 characters. Must include at least one number and one uppercase and lowercase characters.</p>
		</div>
	</div>
	<div class="field">
		<label class="label">Confirm password *</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" id="password2" type="password" name="password2" placeholder="Password" minlength="8" maxlength="255" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<p id="nomatch" class="help is-danger is-hidden">Passwords do not match</p>
		</div>
	</div>
	<div class="field is-grouped">
		<div class="control">
			<button class="button is-primary" id="submit" type="submit" name="submit">Submit</button>
		</div>
		<div class="control">
			<a class="button is-light" href='/'>Cancel</a>
		</div>
	</div>
	<p class="help">All fields marked with asterisks (*) are required.</p>
</form>
</section>
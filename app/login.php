	<script src="js/login.js" defer></script>
		<section class="section">
			<h3 class="title is-3">Login</h3>
			<form id="login">

			<div class="field">
				<label class="label">Username</label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" id="username" name="username" placeholder="Username" minlength="3" maxlength="32" required>
					<span class="icon is-small is-left">
						<svg style="width:24px;height:24px" viewBox="0 0 24 24">
						<path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
						</svg>
					</span>
					<p id="invaliduser" class="help is-danger is-hidden">Invalid username</p>
				</div>
			</div>
			<div class="field">
				<label class="label">Password</label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="255" required>
					<span class="icon is-small is-left">
						<svg style="width:24px;height:24px" viewBox="0 0 24 24">
    					<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
						</svg>
					</span>
					<p id="invalidpassword" class="help is-danger is-hidden">Invalid password</p>
					<p id="notvalidated" class="help is-danger is-hidden">Your account hasn't been validated yet. Check your email for confirmation email or click here to send it again.</p>
				</div>
			</div>

			<div class="field">
				<div class="control">
					<button class="button is-primary" id="submit" name="submit" value="OK">Submit</button>
				</div>
			</div>
		</form>


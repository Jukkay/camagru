<script src="js/signup.js" defer></script>
<section class="section">
	<form id="signup">
	<h3 class="title is-3">Create new account</h3>
	<div class="field">
		<label class="label">Name</label>
		<div class="control">
			<input class="input" type="text" id="name" name="name" placeholder="Name">
		</div>
	</div>
	<div class="field">
		<label class="label">Email</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" type="email" id="email" name="email" placeholder="Email" maxlength="320" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,15C12.81,15 13.5,14.7 14.11,14.11C14.7,13.5 15,12.81 15,12C15,11.19 14.7,10.5 14.11,9.89C13.5,9.3 12.81,9 12,9C11.19,9 10.5,9.3 9.89,9.89C9.3,10.5 9,11.19 9,12C9,12.81 9.3,13.5 9.89,14.11C10.5,14.7 11.19,15 12,15M12,2C14.75,2 17.1,3 19.05,4.95C21,6.9 22,9.25 22,12V13.45C22,14.45 21.65,15.3 21,16C20.3,16.67 19.5,17 18.5,17C17.3,17 16.31,16.5 15.56,15.5C14.56,16.5 13.38,17 12,17C10.63,17 9.45,16.5 8.46,15.54C7.5,14.55 7,13.38 7,12C7,10.63 7.5,9.45 8.46,8.46C9.45,7.5 10.63,7 12,7C13.38,7 14.55,7.5 15.54,8.46C16.5,9.45 17,10.63 17,12V13.45C17,13.86 17.16,14.22 17.46,14.53C17.76,14.84 18.11,15 18.5,15C18.92,15 19.27,14.84 19.57,14.53C19.87,14.22 20,13.86 20,13.45V12C20,9.81 19.23,7.93 17.65,6.35C16.07,4.77 14.19,4 12,4C9.81,4 7.93,4.77 6.35,6.35C4.77,7.93 4,9.81 4,12C4,14.19 4.77,16.07 6.35,17.65C7.93,19.23 9.81,20 12,20H17V22H12C9.25,22 6.9,21 4.95,19.05C3,17.1 2,14.75 2,12C2,9.25 3,6.9 4.95,4.95C6.9,3 9.25,2 12,2Z" />
				</svg>
			</span>
			<p id="emailtaken" class="help is-danger is-hidden">This email address is associated with an existing account.</p>
		</div>
	</div>
	<div class="field">
		<label class="label">Username</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" type="text" id="username" name="username" placeholder="Username" minlength="3" maxlength="32" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
				</svg>
			</span>
			<p id="usernametaken" class="help is-danger is-hidden">This username is not available. Try another one.</p>
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
			<p id="invalidpassword" class="help">Minimum of 8 characters. Must include uppercase and lowercase characters.</p>
		</div>
	</div>
	<div class="field">
		<label class="label">Re-enter password</label>
		<div class="control has-icons-left has-icons-right">
			<input class="input" type="password" id="password2" name="password2" placeholder="Password" minlength="8" maxlength="255" required>
			<span class="icon is-small is-left">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
				<path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
				</svg>
			</span>
			<p id="passwordnotmatch" class="help is-danger is-hidden">Passwords do not match</p>
		</div>
	</div>
	<div class="field">
		<div class="control">
			<label class="checkbox">
				<input type="checkbox" id="tc" name="tc" value="TRUE" required>
			</label>
			I agree to the <a class="js-modal-trigger" id="tcopen">terms and conditions</a>
		</div>
	</div>
	<div class="field is-grouped">
		<div class="control">
			<button class="button is-primary" type="submit" id="submit">Submit</button>
		</div>
		<div class="control">
			<a class="button is-light" href='/'>Cancel</a>
		</div>
	</div>
	</form>
</section>
<div class="modal" id="tcmodal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">Terms and Conditions</p>
			<button class="delete" aria-label="close" id="tcclose"></button>
		</header>
		<section class="modal-card-body">
			<p>
				By signing up to this Web site on the first day of the fourth month of the year 2010 Anno Domini, you agree to grant Us a non-transferable option to claim, for now and for ever more, your immortal soul. Should We wish to exercise this option, you agree to surrender your immortal soul, and any claim you may have on it, within 5 (five) working days of receiving written notification from localhost or one of its duly authorized minions.
			</p>
			<p>
				We reserve the right to serve such notice in 6 (six) foot high letters of fire, however we can accept no liability for any loss or damage caused by such an act. If you a) do not believe you have an immortal soul, b) have already given it to another party, or c) do not wish to grant Us such a license, please click the link below to nullify this sub-clause and proceed with your transaction.
			</p>
		</section>
		<footer class="modal-card-foot">
			<button class="button is-success" id="tcagree">Agree</button>
			<button class="button" id="tccancel">Cancel</button>
		</footer>
	</div>
</div>

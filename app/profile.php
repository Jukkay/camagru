<?php

if (isset($_GET['user']))
	$username = $_GET['user'];
else
	$username = $_SESSION['username'];
?>
<script> let username = '<?php echo $username; ?>'</script>
<script src="js/profile.js" defer></script>
<div class="title is-3 mt-6 block">Profile</div>
<div id="userinfo"></div>
<div class="title is-3 mt-6 block">Gallery</div>
<div id="userimages"></div>
<div class="buttons is-centered">
	<button id="loading" class="button is-loading is-large is-hidden" style="border: none;" disabled>Loading</button>
</div>
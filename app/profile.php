<?php

if (isset($_GET['user']))
	$username = $_GET['user'];
else
	$username = $_SESSION['username'];
?>
<script>
	let username = '<?php echo $username; ?>'
</script>
<style>
	.comment {
		word-break: break-word;
	}
</style>
<script src="js/profile.js" defer></script>
<section class="section">
	<div class="title is-3 mt-6 block">Profile</div>
	<div id="userinfo"></div>
	<div class="title is-3 mt-6 block">Gallery</div>
	<div id="userimages"></div>
</section>
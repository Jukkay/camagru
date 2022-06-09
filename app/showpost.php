<script>
const post_id = '<?php
	if (!isset($_GET['post_id']))
		return;
	echo $_GET['post_id'];
	?>'
	</script>
<script src="js/showpost.js" defer></script>
<div id="post"></div>

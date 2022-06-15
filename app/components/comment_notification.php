<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="section">
<h1 class="title is-1">You received a new comment!</h1>
<p class="block"><strong><?php echo $username; ?></strong> and <?php echo $comments; ?> others commented your post.</p>
<p class="block"><a href="http://localhost/showpost?post_id=<?php echo $post_id; ?>">http://localhost/showpost?post_id=<?php echo $post_id; ?></a></p>
<p class="block">Good job, keep on creating that quality content!</p>
<p class="block has-text-weight-bold">Best regards,</p>
<p class="block has-text-weight-bold">Camagru Team</p>
<figure class="image is-128x128">
	<img src="http://localhost/assets/camagru_logo.svg" alt="Camagru logo">
</figure>
</section>
</body>
</html>
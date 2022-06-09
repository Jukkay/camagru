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
<h1 class="title is-1">Welcome to Camagru</h1>
<p class="block">For the last step of registration we ask you to click the link below to validate this email address.</p>
<p class="block"><a href="http://localhost:8080/confirm?validation_key=<?php echo $validation_key; ?>">http://localhost:8080/confirm?validation_key=<?php echo $validation_key; ?></a></p>
<p class="block has-text-weight-bold">Best regards,</p>
<p class="block has-text-weight-bold">Camagru Team</p>
<figure class="image is-128x128">
	<img src="http://localhost:8080/assets/camagru_logo.svg" alt="Camagru logo">
</figure>
</section>
</body>
</html>
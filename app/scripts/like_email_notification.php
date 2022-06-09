<?php

	$statement = $pdo->prepare("SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE posts.post_id = ?;");
	$statement->execute([$post_id]);
	$post = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$post) {
		return;
	}
	$email_notification = $post['email_notification'];
	if (!$email_notification)
		return;
	$recipient = $post['email'];
	$likes = $post['likes'];
	$subject = 'Somebody liked your post in Camagru!';
	$headers = array(
		'From' => 'jukkacamagru@gmail.com',
		'Reply-To' => 'jukkacamagru@gmail.com',
		'X-Mailer' => 'PHP/' . phpversion(),
		'Content-Type' => 'text/html'
	);
	ob_start();
	include('../components/like_notification.php');
	$message = ob_get_contents();
	ob_end_clean();
	mail($recipient, $subject, $message, $headers);


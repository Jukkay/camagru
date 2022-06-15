<div class="media">
	<div class="media-left">
		<a class="clickable has-text-black" href="/profile?user=<?= $comment['username'] ?>">
			<figure class="image is-48x48">
				<img class="is-rounded" src="/getimage?name=<?= $comment['profile_image'] ?>">
			</figure>
	</div>
	<div class="media-content">
		<strong class="mr-3"><?= $comment['username'] ?></strong></a><?= $comment['comment'] ?>
	</div>
</div>
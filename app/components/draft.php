<div class="tile is-parent box" id="parent<?= $image['image_file'] ?>">
	<article class="tile is-child">
		<div class="buttons is-centered">
			<figure class="image">
				<img src="/getimage?name=<?= $image['image_file'] ?>" id="<?= $image['image_file'] ?>">
			</figure>
			<div class="field is-grouped">
				<p class="control">
					<button class="button is-primary is-small mt-3" id="edit<?= $image['image_file'] ?>">Edit</button>
				</p>
				<p class="control">
					<button class="button is-danger is-small mt-3" id="delete<?= $image['image_file'] ?>">Delete</button>
				</p>
			</div>
		</div>
	</article>
</div>
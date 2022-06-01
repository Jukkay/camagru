<script src="js/newpost.js" defer></script>
<div class="columns">
	<div class="column is-three-quarters">
		<form action="/savepost" method="post">
			<?php
				if (isset($_GET['image']))
					echo '<img id="preview" src="/getimage?name=' . $_GET['image'] . '"alt="Image preview" class="image block is-hidden">';
				else
					echo '<img id="preview" alt="Image preview" class="image block is-hidden">';
			?>
			<textarea class="textarea block" id="description" placeholder="Image description"></textarea>
			<div class="buttons is-centered block">
				<button class="button is-primary">Submit</button>
			</div>
		</form>
	</div>
	<div class="column" id="gallery"></div>
</div>
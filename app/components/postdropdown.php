<div class="dropdown is-hoverable">
	<div class="dropdown-trigger" aria-haspopup="true" aria-controls="dropdown-menu">
		<button class="card-header-icon" aria-label="more options">
			<span id="" class="icon">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
					<path fill="currentColor" d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
				</svg>
			</span>
		</button>
	</div>
	<div class="dropdown-menu" id="dropdown-menu" role="menu">
		<div class="dropdown-content">
			<?php
				if ($post['user_id'] == $_SESSION['user_id']) {
					echo '<a data-id="' . $post['post_id'] . '" class="dropdown-item edit-post">Edit post</a>';
					echo '<a data-id="' . $post['post_id'] . '" class="dropdown-item delete-post">Delete post</a>';
				}
				if (isset($_SESSION['user_id'])) {
					echo '<a data-id="' . $post['post_id'] . '" class="dropdown-item delete-post">Report post</a>';
				}
			?>
		</div>
	</div>
</div>
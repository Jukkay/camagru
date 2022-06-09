<div class="card block" data-id="post<?php echo $post['post_id']; ?>">
	<div class="card-content">
		<div class="media">
			<div class="media-left">
				<figure class="image is-48x48">
					<img src="/getimage?name=<?php echo $post['profile_image']; ?>" alt="Profile picture">
				</figure>
			</div>
			<div class="media-content">
				<p class="title is-4"><?php echo $post['username']; ?></p>
			</div>
			<?php
			if (isset($_SESSION['user_id'])) {
				include "../components/postdropdown.php";
			}
			?>
		</div>
		<div class="card-image">
			<figure class="image">
				<img src="/getimage?name=<?php echo $post['image_file']; ?>" id="<?php echo $post['image_file']; ?>">
			</figure>
		</div>
		<div class="card-content">
			<span class="icon is-medium like-icon <?php if (check_likes($likes, $post['post_id'])) echo 'is-hidden'; ?>" data-id="like<?php echo $post['post_id']; ?>">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
					<path fill="currentColor" d="M12.1 18.55L12 18.65L11.89 18.55C7.14 14.24 4 11.39 4 8.5C4 6.5 5.5 5 7.5 5C9.04 5 10.54 6 11.07 7.36H12.93C13.46 6 14.96 5 16.5 5C18.5 5 20 6.5 20 8.5C20 11.39 16.86 14.24 12.1 18.55M16.5 3C14.76 3 13.09 3.81 12 5.08C10.91 3.81 9.24 3 7.5 3C4.42 3 2 5.41 2 8.5C2 12.27 5.4 15.36 10.55 20.03L12 21.35L13.45 20.03C18.6 15.36 22 12.27 22 8.5C22 5.41 19.58 3 16.5 3Z" />
				</svg>
			</span>
			<span class="icon like-icon is-medium <?php if (!check_likes($likes, $post['post_id'])) echo 'is-hidden'; ?>" data-id="unlike<?php echo $post['post_id']; ?>">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
					<path fill="red" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
				</svg>
			</span>
			<span class="icon is-medium comment-icon" data-id="<?php echo $post['post_id']; ?>">
				<svg style="width:24px;height:24px" viewBox="0 0 24 24">
					<path fill="currentColor" d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10Z" />
				</svg>
			</span><br>
			<span>
				<strong><?php echo $post['likes']; ?> likes</strong>
			</span>
			<p class="block">
				<a class="clickable has-text-black" href="/profile?user=<?php echo $post['username']; ?>">
					<strong class="mr-3"><?php echo $post['username']; ?></strong></a><?php echo $post['description']; ?>
			</p>
			<p class="block">
				<time datetime="<?php echo $post['creation_date']; ?>"><?php echo $post['creation_date']; ?></time>
			</p>
			<p class="block" id="comment-block<?php echo $post['post_id']; ?>" data-id="<?php echo $post['post_id']; ?>">
				<strong class="show-comments" data-id="<?php echo $post['post_id']; ?>">
					<?php
					if ($post['comments'] == 1)
						echo 'Show ' . $post['comments'] . ' comment';
					if ($post['comments'] > 1)
						echo 'Show all ' . $post['comments'] . ' comments'; ?>
				</strong>
			</p>
			<div class="media">
				<div class="media-left">
					<figure class="image is-48x48">
						<img src="/getimage?name=<?php
							if (isset($_SESSION['profile_image']))
								echo $_SESSION['profile_image'];
							else
								echo 'default.png'; ?>" alt="Profile picture">
					</figure>
				</div>
				<div class="media-content">
					<input class="input" type="text" id="input<?php echo $post['post_id']; ?>" placeholder="Write a comment">
					<button class="button comment-button" data-id="<?php echo $post['post_id']; ?>">Comment</button>
				</div>
			</div>
		</div>
	</div>
</div>
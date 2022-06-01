<?php
session_start();
require_once "classes/dbh.class.php";

if (!isset($_GET['uid'])|| !isset($_GET['limit']) || !isset($_GET['page']))
	return "Invalid parameters";
$offset = intval($_GET['limit'] * $_GET['page']);
$limit = intval($_GET['limit']);
$dbh = new Dbh;
$pdo = $dbh->connect();
$statement = $pdo->prepare("SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id LIMIT ? OFFSET ?;");
$statement->bindParam(1, $limit, PDO::PARAM_INT);
$statement->bindParam(2, $offset, PDO::PARAM_INT);
$statement->execute();
$images = $statement->fetchAll(PDO::FETCH_ASSOC);
if (!$images) {
	return;
}

foreach($images as $image) {
	echo '
	<div class="card block">
		<div class="card-content">
			<div class="media">
				<div class="media-left">
					<figure class="image is-48x48">
						<img src="/getimage?name=' . $image['profile_image'] . '" alt="Profile picture">
					</figure>
				</div>
				<div class="media-content">
					<p class="title is-4">' . $image['username'] . '</p>
				</div>
			</div>
			<div class="card-image">
				<figure class="image">
					<img src="/getimage?name=' . $image['image_file'] . '" id="'. $image['image_file'] . '">
				</figure>
			</div>
			<div class="card-content">
				<span class="icon is-medium" onclick=likePost(this.id) id="like'. $image['image_file'] . '">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
						<path fill="currentColor" d="M12.1 18.55L12 18.65L11.89 18.55C7.14 14.24 4 11.39 4 8.5C4 6.5 5.5 5 7.5 5C9.04 5 10.54 6 11.07 7.36H12.93C13.46 6 14.96 5 16.5 5C18.5 5 20 6.5 20 8.5C20 11.39 16.86 14.24 12.1 18.55M16.5 3C14.76 3 13.09 3.81 12 5.08C10.91 3.81 9.24 3 7.5 3C4.42 3 2 5.41 2 8.5C2 12.27 5.4 15.36 10.55 20.03L12 21.35L13.45 20.03C18.6 15.36 22 12.27 22 8.5C22 5.41 19.58 3 16.5 3Z" />
					</svg>
				</span>
				<span class="icon is-medium"  onclick=goToComment(this.parentNode) id="comment_icon'. $image['image_file'] . '">
					<svg style="width:24px;height:24px" viewBox="0 0 24 24">
						<path fill="currentColor" d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10Z" />
					</svg>
				</span><br>
				<span>
					<strong>' . $image['likes'] . ' likes</strong>
				</span>
				<p class="block">
					<strong class="mr-3">' . $image['username'] . '</strong>' . $image['description'] .
				'</p>
				<p class="block">
					<time datetime="' . $image['creation_date'] . '">' . $image['creation_date'] . '</time>
				</p>
				<p class="block" onclick=showComments(this)>
					<strong id="show_comments'. $image['image_file'] . '">';
	if ($image['comments'] == 1)
		echo 'Show ' . $image['comments'] . ' comment';
	if ($image['comments'] > 1)
		echo 'Show all ' . $image['comments'] . ' comments';
	echo '			</strong>
				</p>
				<div class="media">
				<div class="media-left">
					<figure class="image is-48x48">
						<img src="/getimage?name=' . $_SESSION['profile_image'] . '" alt="Profile picture">
					</figure>
				</div>
				<div class="media-content">
					<input class="input" type="text" id="comment'. $image['image_file'] . '" placeholder="Write a comment">
					<button class="button" onclick=commentPost(this.previousElementSibling.id)>Comment</button>
				</div>
			</div>
		</div>
	</div>';
}
if (count($images) < $limit) {
	echo '
		<div class="is-centered">
			<h3 class="title is-3">No more posts to show</h3>
		</div>
	';
}
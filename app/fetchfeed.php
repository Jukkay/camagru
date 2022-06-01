<?php
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
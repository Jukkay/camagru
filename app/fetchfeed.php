<?php
require_once "classes/dbh.class.php";

if (!isset($_GET['uid'])|| !isset($_GET['limit']) || !isset($_GET['page']))
	return "Invalid parameters";
$offset = intval($_GET['limit'] * $_GET['page']);
$limit = intval($_GET['limit']);

$dbh = new Dbh;
$pdo = $dbh->connect();
$statement = $pdo->prepare("SELECT * FROM editor WHERE uid = ? LIMIT ? OFFSET ?;");
$statement->bindParam(1, $_GET['uid'], PDO::PARAM_STR);
$statement->bindParam(2, $limit, PDO::PARAM_INT);
$statement->bindParam(3, $offset, PDO::PARAM_INT);
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
						<img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
					</figure>
				</div>
				<div class="media-content">
					<p class="title is-4">John Smith</p>
				</div>
			</div>
			<div class="card-image">
				<figure class="image">
					<img src="/getimage?name=' . $image['img'] . '" id="'. $image['img'] . '">
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
<?php
session_start();
require_once "../classes/dbh.class.php";

if (!isset($_GET['user_id']) || !isset($_GET['limit']) || !isset($_GET['page']))
	return "Invalid parameters";
$offset = intval($_GET['limit'] * $_GET['page']);
$limit = intval($_GET['limit']);
$user_id = intval($_GET['user_id']);
$dbh = new Dbh;
$pdo = $dbh->connect();
$statement = $pdo->prepare("SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id LIMIT ? OFFSET ?;");
$statement->bindParam(1, $limit, PDO::PARAM_INT);
$statement->bindParam(2, $offset, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement = $pdo->prepare("SELECT posts.post_id FROM posts INNER JOIN likes ON posts.post_id = likes.post_id AND likes.user_id = ?;");
$statement->bindParam(1, $user_id, PDO::PARAM_INT);
$statement->execute();
$likes = $statement->fetchAll(PDO::FETCH_ASSOC);

function check_likes ($likes, $post_id) {
	foreach($likes as $key => $value) {
		if ($value['post_id'] == $post_id)
			return true;
	}
	return false;
}

if (!$posts) { ?>
	<div class="has-text-centered">
		<h3 id="nomore" class="title is-3">No more posts to show</h3>
	</div>
<?php
	return;
}

foreach($posts as $post) {
	require "../components/post.php";
}
if (count($posts) < $limit) { ?>
		<div class="has-text-centered">
			<h3 id="nomore" class="title is-3">No more posts to show</h3>
		</div>
<?php
}
?>
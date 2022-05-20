<?php
require_once "classes/dbh.class.php";

if (!isset($_GET['uid']))
	return "UID NOT SET!!";

$dbh = new Dbh;
$pdo = $dbh->connect();

$statement = $pdo->prepare("SELECT * FROM editor WHERE uid = ?;");
$statement->execute([$_GET['uid']]);
$images = $statement->fetchAll(PDO::FETCH_ASSOC);
if (!$images) {
	return;
}
foreach($images as $image) {
	echo '
	<div class="tile is-parent box">
		<article class="tile is-child">
			<div class="buttons is-centered">
				<figure class="image">
					<img src="/getimage?name=' . $image['img'] . '">
				</figure>
				<button class="button is-primary is-small mt-3">Select</button>
			</div>
		</article>
	</div>';
}
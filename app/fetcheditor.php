<?php
require_once "classes/dbh.class.php";

if (!isset($_GET['uid']))
	return "UID NOT SET!!";
echo '<h2 class="subtitle">Drafts</h2>';
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
	<div class="tile is-parent box" id="parent'. $image['img'] . '">
		<article class="tile is-child">
			<div class="buttons is-centered">
				<figure class="image">
					<img src="/getimage?name=' . $image['img'] . '" id="'. $image['img'] . '">
				</figure>
				<div class="field is-grouped">
					<p class="control">
						<button class="button is-primary is-small mt-3" id="edit'. $image['img'] . '">Edit</button>
					</p>
					<p class="control">
						<button class="button is-danger is-small mt-3" id="delete'. $image['img'] . '">Delete</button>
					</p>
				</div>
			</div>
		</article>
	</div>';
}
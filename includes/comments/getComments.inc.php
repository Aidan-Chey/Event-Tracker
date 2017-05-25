<?php //Function to get the comments relating to the called event from the comments table
function getComments($event) {
	if (!is_numeric($event)) {
		$error = "Error, event ID for comments retrieval is not numeric";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return false;
	}

	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
	try {
		$s=$pdo->prepare("SELECT `users`.`name`,`comments`.`created`,`comments`.`content` FROM `comments` INNER JOIN `users` ON `comments`.`user_id` = `users`.`id` WHERE `comments`.`event_id` = :event ORDER BY `created` DESC");
		$s->execute(array(':event'=>$event));
	} catch (PDOException $e) {
		$error = "Error occured while retrieving event comments";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return false;
	}

	return $s->fetchAll(PDO::FETCH_ASSOC);
}
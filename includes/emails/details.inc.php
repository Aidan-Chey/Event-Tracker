<?php //Function to retrieve the nessesary details for sending out emails about an event
function eventDetails($eventID,$table) {
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	$mysql_event_email = "
		`user_id`
		,`status`
		,`location`
		,`type`
		,FROM_UNIXTIME(`start`,'".mysql_dateTime."') AS 'start'
		,FROM_UNIXTIME(`end`,'".mysql_dateTime."') AS 'end'
		,`description`
		,(CASE WHEN `placeholder` > \"t\" THEN 'Yes' ELSE 'No' END) as 'placeholder'
		,(SELECT `email` FROM `users` WHERE `id` = `user_id`) as 'requester'
		,(SELECT `email` FROM `users` WHERE `id` = `user_id`) as 'requester_email'
	";

	try {
		$s = $pdo->prepare(
			"SELECT $mysql_event_email
			FROM `$table`
			WHERE `id` = :id
			LIMIT 1");
		$s->execute(array(':id'=>$eventID));
	} catch (PDOException $e) {
		$error = 'Error retreiving event details for emailing. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	return $s->fetch(PDO::FETCH_ASSOC);
}
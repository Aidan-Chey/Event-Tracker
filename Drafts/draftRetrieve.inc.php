<?php //Retrive a draft event's data
if(isset($_GET['edit']) && !empty($_GET['listSelect'])){
	try{
		$s = $pdo->prepare(
			"SELECT $mysql_draft_display
			From `drafts`
			WHERE `user_id` = :user_id
			AND `id` = :id
			LIMIT 1"
		);
		$s->execute(array(
			':id' => $_GET['listSelect']
			,':user_id' => $_SESSION['user']['id'])
		);
	}
	catch(PDOException $e){
		$error = 'Error retrieving draft data';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$details = $s->fetchAll(PDO::FETCH_ASSOC)[0];
}
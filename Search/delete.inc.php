<?php //Script for deleting events
function deleteEvent($event_id) {
	//Retrieve event for deletion
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
	try{
		$s = $pdo->prepare("SELECT * FROM `events` WHERE `id` = :id LIMIT 1");
		$s->execute(array(':id'=>$event_id));
	}catch(PDOException $e) {
		$error = 'Error retrieving event information for cancel.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$event = $s->fetch(PDO::FETCH_ASSOC);

	if(!empty($event)){
		//setup the placeholders for each individual piece of data
		$event['status'] = 'cancelled';

		foreach ($event as $key => $value) {
			$binds[$key] = ":$key";
			$placeholders[":$key"] = $value;
		}

		$datafields = '`'.implode('`,`',array_keys($event)).'`';
		$binds = implode(',', $binds);

		//Uploads the information to archive and deletes original
		$pdo->beginTransaction();
		try{
			$i = $pdo->prepare("INSERT INTO `archives` ($datafields) VALUES ($binds) ON DUPLICATE KEY UPDATE id = id");
			$i->execute($placeholders);
			$d = $pdo->prepare("DELETE FROM `events` WHERE `id` = :id LIMIT 1");
			$d->execute(array(':id'=>$event_id));
		}
		catch(PDOException $e){
			$pdo->rollback();
			$error = 'Error moving event to archives after cancel.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/audit.inc.php';
		$transaction_id = audit($_SESSION['user']['id'],'event',$event_id,'Event Cancel',$event);
		if(empty($transaction_id)) {
			$pdo->rollback();
			$error = 'Error creating audit entry for cancelled event.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/event_cancel.php';
		if(!eventCancel($_SESSION['user']['id'].' - '.$_SESSION['user']['name'],$event_id,$transaction_id)) {
			$pdo->rollback();
			$error = 'Error sending event cancel emails.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		$pdo->commit();

		$_SESSION['messages'] = ' Event cancelled.';
		header("Location: /Search");
		exit();
	}else{
		$_SESSION['messages'] = ' Event not found for cancel.';
	}
}
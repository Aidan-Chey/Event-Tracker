<?php
if(isset($_POST['create'])) {
	if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
		include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
	}

	//Setting up the variables for the SQL event
	$placeholders = array();
	$event = array(
		'status' => 'apply'
		,'type' => 'new'
		,'user_id' => $_SESSION['user']['id']
		,'created' => strtotime('now')
		,'last_change' => strtotime('now')
		,'placeholder' => ( empty( $_POST['placeholder'] ) ? 'f' : 't' )
	);

	//A collection of the fields from the form to be included in he event
	$uniqueFields = array('location','description');
	$timeFields = array('start','end');

	//Add unique fields to event
	foreach($uniqueFields as $value){
		if(isset($_POST["$value"]) && $_POST["$value"] !=''){
			$event["$value"] = $_POST["$value"];
		}
	}

	//Adds each of the time fields to event
	foreach ($timeFields as $pos) {
		foreach (array('date','time') as $type) {
			if(!empty($_POST["$pos"]["$type"])) {
				$event["$pos"][] = $_POST["$pos"]["$type"];
			}
		}
		$event["$pos"] = strtotime(implode(' ',$event["$pos"]));
	}

	//Organises event information for SQL query
	foreach ($event as $key => $value) {
		$set[] = " `$key` = :$key";
		$placeholders[":$key"] = $value;
	}

	$set = implode(',', $set);

	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
	$pdo->beginTransaction();

	//Inserts the event into the DB
	try{
		$s = $pdo->prepare("INSERT INTO `events` SET $set");
		$s->execute($placeholders);
	}
	catch(PDOException $e){
		$error = 'Error submting new event.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$event_id = $pdo->lastInsertId();

	if(!empty($_POST['comment']) && !empty($event_id)) {
		include $_SERVER['DOCUMENT_ROOT'].'/includes/comments/upload.inc.php';
		$transactionId = commentUpload($event_id,$_SESSION['user']['id'],$_POST['comment']);
	}

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/audit.inc.php';
	$transaction_id = audit($_SESSION['user']['id'],'event',$event_id,'Event Created',$event);
	if(empty($transaction_id)) {
		$pdo->rollback();
		$error = 'Error creating audit entry for new event.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	$pdo->commit();

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/event_new.php';
	if(!eventNew($event_id,$transaction_id)) {
		$error = 'Error sending event notification emails.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	}

	//sets a success message and loads the event in the search page
	$_SESSION['messages'] = " Event created.";
	header('Location: /Search/?id='.$event_id.'&Asked#event');
	exit();
}
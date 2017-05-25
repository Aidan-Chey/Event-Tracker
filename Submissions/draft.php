<?php //Save the event as a draft
if(userHasRole(array('basic','operator','manager','admin'))) {
	//Connect to DB
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	// The insert statement
	$event = array('user_id' => $_SESSION['user']['id'],'saved' => strtotime('now'),'created' => strtotime('now'));
	$placeholders = array();

	//A collection of the fields from the form
	$uniqueFields = array('type','location','description','assoc_id');
	$timeFields = array('start','end');


	//adds the uniquefields to event
	foreach($uniqueFields as $value){
		if(!empty($_POST["$value"])){
			$event["$value"] = $_POST["$value"];
		}
	}

	//adds the time fields to event
	foreach ($timeFields as $pos) {
		foreach (array('date','time') as $type) {
			if(!empty($_POST["$pos"]["$type"]) && strtotime($_POST["$pos"]["$type"])) {
				$event["$pos"][] = $_POST["$pos"]["$type"];
			}
		}
		if(!empty($event["$pos"]) ) $event["$pos"] = strtotime(implode(' ',$event["$pos"]) );
	}

	//Organises event information for SQL query
	foreach ($event as $key => $value) {
		if(empty($set)){
			$set = "`$key`=:$key";
		}else{
			$set .= ",`$key`=:$key";
		}
		$placeholders[":$key"] = $value;
	}

	//Uploads the information
	try {
		$s = $pdo->prepare("INSERT INTO `drafts` SET $set");
		$s->execute($placeholders);
	} catch(PDOException $e) {
		$error = 'Error saving form data';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	//sets a success message and loads the event in the search page
	$_SESSION['messages'] = " Event Saved.";
	header('Location: /Drafts/');
	exit();
}else{
	header('Location: /');
	exit();
}
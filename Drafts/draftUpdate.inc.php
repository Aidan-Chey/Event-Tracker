<?php //Script to edit an existing draft event
if(isset($_POST['save'])){
	// The update statement
	$event = array(
		'user_id' => $_SESSION['user']['id']
		,'saved'=>strtotime('now')
		,'placeholder' => ( empty( $_POST['placeholder'] ) ? 'f' : 't' )
	);
	$placeholders = array(':id' => $_POST['id']);

	//A collection of the fields from the form
	$uniqueFields = array('location','description');
	$timeFields = array('start','end');

	//adds the unique fields to event
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
		$event["$pos"] = strtotime(implode(' ',$event["$pos"]) );
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
	try{
		$s = $pdo->prepare("UPDATE `drafts` SET $set WHERE `id` = :id LIMIT 1");
		$s->execute($placeholders);
	}
	catch(PDOException $e){
		$error = 'Error saving form data';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	//sets a success message and loads the request in the search page
	$_SESSION['messages'] = " Request Saved.";
}
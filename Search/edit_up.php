<?php
if(userHasRole('')){
	header('Loaction: /?Permission');
	exit();
}

// The insert statement
$event = array(
	'last_change' => strtotime('now')
	,'placeholder' => ( empty( $_POST['placeholder'] ) ? 'f' : 't' )
);
$where = " `id` = '".$_POST['listSelect']."'";
$placeholders = array();

if($_POST['status'] == 'decline') {
	$event['status'] = 'apply';
}

//A collection of the Unique fields from the form
$uniqueFields = array('location','description');

$datetimes = array('start','end');

//Add Unique values to SQL
foreach($uniqueFields as $value){
	// if field is not empty, add it to the SQL query
	if(isset($_POST["$value"]) && $_POST["$value"] !=''){
		$event[$value] = $_POST["$value"];
	}
}

//Add Dates andTimes to SQL
foreach ($datetimes as $value) {
	if(isset($_POST["$value"]) && count($_POST["$value"]) > 0 ){
		$event[$value] = strtotime( implode(' ',$_POST["$value"]) );
	}
}

//Organises event information for SQL query
foreach ($event as $key => $value) {
	$set[] = " `$key` = :$key";
	$placeholders[":$key"] = $value;
}

$set = implode(', ', $set);

$pdo->beginTransaction();

//Uploads the information
try{
	$s = $pdo->prepare("UPDATE `events` SET $set WHERE $where");
	$s->execute($placeholders);
}
catch(PDOException $e){
	$error = 'Error updating event edit. ';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/audit.inc.php';
$transaction_id = audit($_SESSION['user']['id'],'event',$_POST['listSelect'],'Event Edited',$event);
if(empty($transaction_id)) {
	$pdo->rollback();
	$error = 'Error creating audit entry for edited event.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/event_edit.php';
if(!eventEdit($_SESSION['user']['id'].' - '.$_SESSION['user']['name'],$_POST['listSelect'],$transaction_id)) {
	$pdo->rollback();
	$error = 'Error sending event edit emails.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}

$pdo->commit();

//sets a success message and loads the event in the search page
$_SESSION['messages'] = " Event Edited.";
if(!empty($_POST['listSelect'])) header('Location: /Search?id='.$_POST['listSelect'].'&Asked#event');
else header('Location: /Search/?');
exit();
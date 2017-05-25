<?php
$pageTitle = 'New Event';
$links = array('form');
$javas = array('hotkeys');
$onLoad = "";

//addons to assist with injection
include $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(userHasRole('')){
	header("Location: /?Permissions");
	exit;
}

//Update user details
if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
}

//variable to help templates know which files to use
$type='new';

if(isset($_POST['create'])){

	include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/event.inc.php';

	if(empty($errors)){
		include 'event_up.php';
	}else{
		$_SESSION['messages'] = 'Errors were found';
	}
}
elseif(isset($_POST['save'])){
	include '../draft.php';
}

if(isset($_GET['duplicate']) && !empty($_GET['id'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Choose table to query
	if(isset($_GET['archive'])){
		$table = 'archives';
	}else{
		$table = 'events';
	}

	try {
		$s=$pdo->prepare("SELECT * FROM `$table` WHERE `type`='$type' AND `id`=:id LIMIT 1");
		$s->execute(array(':id'=>$_GET['id']));
	} catch (PDOException $e) {
		$errors['general'] = 'Error, unable to retrieve event details for duplication.';
	}
	$details = $s->fetchAll(PDO::FETCH_ASSOC)[0];
}else{
	if(!empty($_GET['id'])){ $details['register_id'] = $_GET['id']; }
	if(!empty($_GET['loc'])){ $details['location'] = $_GET['loc']; }
	if(!empty($_GET['srt'])){ $details['start'] = $_GET['srt']; }
	if(!empty($_GET['end'])){ $details['end'] = $_GET['end']; }
	if(!empty($_GET['dsc'])){ $details['description'] = $_GET['dsc']; }
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

//variables to help templates know what files to use.
$form='edit';
$creating=TRUE;

include '../request_event.html.php';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';


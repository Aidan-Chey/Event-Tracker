<?php
$pageTitle = 'Search';
$links = array('table','form','search');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(!userLoggedIn()){
	header('Location: /');
	exit();
}

//Connect to Database
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

//Update user details
if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
}

$errors = array();
if( isset($_POST['submit']) ){
	//Validation
	include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/event.inc.php';
	// if no errors upload information
	if(empty($errors)){
		include 'edit_up.php';
	}
}

//Deleting Event
if(!empty($_POST['cancel'])){
	include 'delete.inc.php';
	deleteEvent($_POST['cancel']);
}

if(isset($_GET['Asked'])) { include 'search.php'; }

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'search.html.php';

if(!empty($_POST['listSelect']) || !empty($_GET['id'])){
	// Retrieve Event based on supplied ID
	if(!empty($_POST['listSelect']) && is_numeric($_POST['listSelect'])){
		$eventID = $_POST['listSelect'];
	}
	elseif(!empty($_GET['id']) && is_numeric($_GET['id'])){
		$eventID = $_GET['id'];
	}

	if(isset($_GET['archive'])){$table = '`archives`';}else{$table = 'events';}

	try{
		$s = $pdo->prepare("SELECT $mysql_event_display FROM `$table` WHERE `id` = :id LIMIT 1");
		$s->execute(array(':id'=>$eventID));
	}catch(PDOException $e){
		if(DEVELOPMENT){
			$error = 'Error retrieving event information for viewing. '.$e->getMessage();
		}else{
			$error = 'Error retrieving event information for viewing.';
		}
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	if($s->rowCount() >0){
		$details = $s->fetchAll(PDO::FETCH_ASSOC)[0];

		if(isset($_POST['edit'])){
			include 'edit.html.php';
		}
		elseif(isset($_POST['view']) || !empty($_GET['id'])){
			include 'view.php';
		}
	}
}

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
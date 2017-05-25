<?php
$pageTitle = 'Drafts';
$links = array('table','form');
$javas = array('hotkeys');
$onLoad = "";

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(userHasRole('')){
	header('Location: /?Permission');
	exit();
}

//Connect to DB
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

//Update user details
if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
}

//Scripts to handle different calls
if(isset($_POST['save'])){
	include 'draftUpdate.inc.php';
}
if(isset($_POST['delete'])){
	include 'draftDelete.inc.php';
}

//Retrieve Draft Summaries under User's ID
try{
	$s = $pdo->prepare(
		"SELECT $mysql_draft_list
		FROM `drafts`
		WHERE `user_id` = :user_id"
	);
	$s->execute(array(':user_id'=>$_SESSION['user']['id']));
}catch(PDOException $e) {
	$error = 'Error retrieving draft list. '.$e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
$drafts = $s->fetchAll(PDO::FETCH_ASSOC);

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'draftSelect.html.php';

if(isset($_GET['edit']) && !empty($_GET['listSelect'])) {
	include 'draftRetrieve.inc.php';

	include 'draft.html.php';
}

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
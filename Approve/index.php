<?php
$pageTitle = 'Approval';
$links = array('table','form');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

//Connect to DB
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

//Update user details
if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
}

//if a event has been approved or declined
if(isset($_POST['approve']) || isset($_POST['decline'])){
	//$role='manager';
	include 'approve.php';
}

try{
	$s = $pdo->prepare(
		"SELECT $mysql_event_list FROM `events` WHERE `status` = 'confirm' AND `placeholder` = 0 ORDER BY `start` ASC");
	$s->execute();
}
catch(PDOException $e){
	$error = 'Error retrieving events list for approval.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
$events = $s->fetchAll(PDO::FETCH_ASSOC);

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'approve.html.php';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
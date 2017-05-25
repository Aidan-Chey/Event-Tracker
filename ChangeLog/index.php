<?php
$pageTitle = 'Change Log';

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(!userLoggedIn()){
	header('Location: /?Permission');
	exit();
}

//Connect to Database
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

try{
	$s = $pdo->prepare(
		"SELECT `created`
		,`change`
		FROM `changelog`
		WHERE `created` > :created
		ORDER BY `created` DESC");
	$s->execute(array(':created'=>strtotime('6 months ago')));
}
catch (PDOException $e){
	$error = 'Error retrieving change log.';
	include  $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}

if($s->rowCount() > 0) {
	$log = $s->fetchAll(PDO::FETCH_ASSOC);
	foreach ($log as $value) {
		$rawDays[] = $value['created'];
	}

	$uniqueDays = array_unique($rawDays);
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'log.html.php';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
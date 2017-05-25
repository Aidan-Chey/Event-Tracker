<?php
$pageTitle = 'Home';
$links = array('home');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(!userLoggedIn()){
	header('Location: /Authentication/Login/');
	exit();
}

require $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

//Retrieve approvals counts
$counts=array();
$sql= array(
	'apply' => "SELECT COUNT(*) FROM `events` WHERE `status` = 'apply'"
	,'confirm' => "SELECT COUNT(*) FROM `events` WHERE `status` = 'confirm' AND `placeholder` = 0"
);
$pdo->beginTransaction();
foreach ($sql as $key => $value) {
	try {
		$$key = $pdo->prepare($value);
		$$key->execute();
	} catch (PDOException $e) {
		$error = ' Error retrieving approval count for '.$key;
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	}
}
$pdo->commit();
foreach ($sql as $key => $value) {
	$counts[$key] = $$key->fetch()[0];
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

if(isset($_GET['Permission'])) {
	include 'permission.html';
} else {
	include 'home.html.php';
}

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
<?php
//Login Check
function userLoggedIn(){
	// Demo Info
	$_SESSION['domain'] = $_SERVER['HTTP_HOST'];
	$_SESSION['loggedIn'] = true;
	$_SESSION['user']['email'] = 'demo@eventtracker.com';
	$_SESSION['user']['password'] = 'demopassword';
	// stop demo info

	if (isset($_SESSION['loggedIn']) && !empty($_SESSION['user']) && databaseContainsUser($_SESSION['user']['email'], $_SESSION['user']['password'])){
		return userVerified();
	}
	return false;
}

function databaseContainsUser($email, $password){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Compare _SESSIONed Email and Password
	try{
		$sql = "SELECT '' FROM `users` WHERE `email` = :email AND `password` = :password LIMIT 1";
		$s = $pdo->prepare($sql);
		$s->bindValue(':email', $email);
		$s->bindValue(':password', $password);
		$s->execute();
	}
	catch (PDOException $e){
		$error = 'Error searching for User.';
		include  $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	if ($s->rowCount() > 0){
		return TRUE;
	}
	else{
		return FALSE;
	}
}
function userHasRole($roles){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	if(empty($roles)) {
		$role = 'IS NULL';
	}else if(is_array($roles)) {
		$role = 'IN (\''.implode('\',\'',$roles).'\')';
	}else{
		$role = "= '$roles'";
	}

	//Check User has Role
	try{
		$sql = "SELECT '' FROM `users` WHERE `email` = :email AND `role` $role LIMIT 1";
		$s = $pdo->prepare($sql);
		$s->execute(array(':email'=>$_SESSION['user']['email']));
	}
	catch (PDOException $e){
		$error = 'Error searching for roles.';
		include  $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	if ($s->rowCount() > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function userVerified(){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	if(empty($_SESSION['user']['email'])){$email = null;}
	else{$email = $_SESSION['user']['email'];}

	// Check User id Verified
	try{
		$sql = "SELECT '' FROM `users` WHERE `email` = :email AND `verified` = '1' LIMIT 1";
		$s = $pdo->prepare($sql);
		$s->bindValue(':email', $email);
		$s->execute();
	}
	catch (PDOException $e){
		$error = 'Error locating verified account.';
		include  $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	if ($s->rowCount() > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

//Set default timezone
date_default_timezone_set('NZ');

//Check session started
if(session_id() == '') {
	session_start();
}

//Check session domain
if(!isset($_GET['logout']) && userLoggedIn() && $_SESSION['domain'] != $_SERVER['HTTP_HOST']){
	header('Location: /?logout');
	exit();
}

define('pSalt','$2a$11$kiposlekdi8454632597ivu$');

if(getenv('ENVIRONMENT') == 'DEVELOPMENT') define('DEVELOPMENT',1);
else define('DEVELOPMENT',0);

//Logout Attempts
if(isset($_GET['logout'])){
	session_unset();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
	$_SESSION['messages'] = " Logged out.";
}

//Unsubscribe Attempts
if(!empty($_GET['Unsubscribe'])){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Set user's subscribed variable to 0
	try{
		$sql = "UPDATE `users` SET `subscribed` = '0' WHERE `unsubscribe` = :code LIMIT 1";
		$s = $pdo->prepare($sql);
		$s->bindValue(':code', $_GET['Unsubscribe']);
		$s->execute();
	}
	catch (PDOException $e){
		$error = 'Error unsubscribing account.';
		include  $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$_SESSION['messages'] = " Successfully Unsubscribed";
}
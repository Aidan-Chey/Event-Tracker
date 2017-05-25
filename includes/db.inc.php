<?php
//database connection query
try{
	$pdo = new PDO('mysql:host=putHostAdddressHere;dbname=puDatabaseNameHere','PutDatabaseUsernameHere','PutDatabasePasswordHere');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e){
	$error = 'Unable to connect to the database server. '.$e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
<?php
//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if (!userHasRole('admin')){
	header('Location: /?Permission');
}

//Connect to DB
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

//Retrieve events to be archived
try{
	$s = $pdo->query("SELECT * FROM events WHERE `end` < '".strtotime('- 2 Month')."'");
}catch(PDOException $e) {
	$error = 'Error retrieving event information.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
foreach($s->fetchAll(PDO::FETCH_ASSOC) as $value){
	foreach ($value as $k => $v) {
		if(is_int($k)){
			unset($value["$k"]);
		}
	}
	$events[] = $value;
	$ids[] = $value['id'];
}
if(!empty($events)){

	//setup the placeholders for each individual piece of data
	foreach ($events as $key => $value) {
		foreach ($value as $inc => $raw) {
			$placeholders[":$key$inc"] = $raw;
			$binds[$key][$inc] = ":$key$inc";
		}
	}

	//implode the data in each column array to be used in MySQL query
	foreach ($binds as $key => $value) {
		$binds[$key] = "(".implode(',', $value).")";
	}

	$datafields = array_keys($events[0]);

	//MySQL query setup
	$sqlInsert = "INSERT INTO archives (`".implode('`,`', $datafields)."`) Values ".implode(',', $binds)." ON DUPLICATE KEY UPDATE id=id";
	$sqlDelete = "DELETE FROM events WHERE `id` IN (".implode(',', $ids).")";

	//Uploads the information to archives
	$pdo->beginTransaction();
	try{
		$i = $pdo->prepare($sqlInsert);
		$i->execute($placeholders);
		$d = $pdo->prepare($sqlDelete);
		$d->execute();
	}
	catch(PDOException $e){
		$pdo->rollback();
		$error = 'Error moving events to archives.'.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$pdo->commit();

	$_SESSION['messages'] = ' Old events archived.';
}else{
	$_SESSION['messages'] = ' No events meet archive requirments.';
}
<?php
$pageTitle = 'Audit';
$links = array('table','search','audit');

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

if(!userLoggedIn()){
	header('Location: /Authentication/Login/');
	exit();
}

function changeSpliter($input){
	$explode = substr($input,1,-1);
	$explode = explode('],[',$explode);
	foreach ($explode as $value) {
		$array = explode(']=>[',$value);
		$output[$array[0]] = !empty($array[1])?$array[1]:null;
	}
	return $output;
}

if(isset($_GET['Asked'])){
	//Validate name
	if(!empty($_GET['user_id']) && !strlen($_GET['user_id']) > 25) {
		$errors['user_id'] = ' Requester name too long (max 25 characters).';
	}
	//Validate ID
	if(!empty($_GET['id']) && !is_numeric($_GET['id'])) {
		$errors['id'] = ' Please use a numeric id.';
	}
	//Validate date
	if(!empty($_GET['ts'])){
		if(!strtotime($_GET['ts'])){
			$errors['ts'] = ' Unable to recognise date format; try YYYY-MM.';
		}
	}

	if(empty($errors)){
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

		$placeholders=array();
		$where=array();
		$audit = array(
			'name' => $_GET['name']
			,'id' => $_GET['id']
			,'ts' => date('Y-m',strtotime($_GET['ts']))
		);

		// A date is selected
		if (!empty($_GET['ts'])){
			$where[] = "`ts` <= :lastdate";
			$where[] = "`ts` >= :firstdate";
			$placeholders[':firstdate'] = date('Y-m-d',strtotime($_GET['ts']));
			$placeholders[':lastdate'] = date('Y-m-t',strtotime($_GET['ts']));
		}
		// A date is selected
		if (!empty($_GET['id'])){
			$where[] = "`id` LIKE :id";
			$placeholders[':id'] = "%".$_GET['id']."%";
		}
		// A date is selected
		if (!empty($_GET['item_id'])){
			$where[] = "`item_id` LIKE :item_id";
			$placeholders[':item_id'] = "%".$_GET['item_id']."%";
		}
		// A name is selected
		if (!empty($_GET['name'])){
			$where[] = "`user_id` IN (SELECT `user_id` FROM `users` WHERE `name` like :name)";
			$placeholders[':name'] = "%".$_GET['name']."%";
		}
		if(!empty($where)){
			$where = implode(' AND ',$where);
		}else{
			$where = 'TRUE';
		}

		try {
			$s=$pdo->prepare(
				"SELECT $mysql_audit_list
				FROM `audits`
				WHERE $where
				ORDER BY `ts` DESC");
			$s->execute($placeholders);
		} catch (PDOException $e) {
			$error = 'Error retrieving audit search data. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		$audits = $s->fetchAll(PDO::FETCH_ASSOC);
	}
}

if (isset($_POST['view']) && !empty($_POST['listSelect'])) {
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	$s=$pdo->prepare(
		"SELECT $mysql_audit_display
		FROM `audits`
		WHERE `id` = :id
		LIMIT 1");

	try {
		$s->execute(array(':id'=>$_POST['listSelect']));
	} catch (PDOException $e) {
		$error = 'Error retrieving audit transaction data.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}


	foreach ($s->fetchAll(PDO::FETCH_ASSOC)[0] as $key => $value) {
		if($key=='original' || $key=='changed'){
			$transaction["$key"] = changeSpliter($value);
		}else{
			$transaction["$key"] = $value;
		}
	}
	$trans_table = array();
	if(strpos($transaction['action'], 'New') !== false){
		foreach ($transaction['changed'] as $key => $value) {
			$trans_table[] = array(
				'field' => ucfirst($key)
				,'new' => (!empty($value) && in_array($key, array('start','end','created'))? date(php_dateTime,$value) : $value ) );
		}
	}else{
		foreach ($transaction['original'] as $key => $value) {
			$trans_table[] = array(
				'field' => ucfirst($key)
				,'original' => (!empty($value) && in_array($key, array('start','end','created'))? date(php_dateTime,$value) : $value )
				,'new' => (!empty($transaction['changed'][$key]) && in_array($key, array('start','end','created'))? date(php_dateTime,$transaction['changed'][$key] ) : $transaction['changed'][$key] ) );
		}
	}
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'criteria.html.php';

if(!empty($audits)) {
	include 'search.html.php';
}

if(!empty($transaction)){
	include 'audit.html.php';
}

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
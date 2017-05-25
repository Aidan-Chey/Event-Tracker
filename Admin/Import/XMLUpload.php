<?php
$errors = array();

//File Types to allow through
$mimes = array('application/xml','text/xml');

//columns to use
$use = array();

//if nothing uploaded
if(empty($_FILES['upload'])){
	$errors['upload'] = " No file was uploaded.";
}
//if an error occurs during upload
elseif(!empty($_FILES['upload']['error'])){
	switch ($_FILES['upload']['error']) {
		case 1:
			$errors['upload'] = " An error occured durning upload (uploaded file exceeds max size specified in php.ini).";
			break;
		case 2:
			$errors['upload'] = " An error occured durning upload (uploaded file exceeds max size specified in HTML).";
			break;
		case 3:
			$errors['upload'] = " An error occured durning upload (uploaded file only partially uploaded).";
			break;
		case 4:
			$errors['upload'] = " An error occured durning upload (No file was uploaded).";
			break;
		case 6:
			$errors['upload'] = " An error occured durning upload (missing a temporary folder).";
			break;
		case 7:
			$errors['upload'] = " An error occured durning upload (Failed to write file to disk).";
			break;
		case 8:
			$errors['upload'] = " An error occured durning upload (Php extention stopped file upload).";
			break;
	}
}
//if uploaded file not XML
elseif(!in_array($_FILES['upload']['type'],$mimes)){
	$errors['upload'] .= " Specified file not XML format.";
}
else{
	$file = simplexml_load_file($_FILES['upload']['tmp_name']);
	$count = 0;
	//group information for upload
	foreach($file->Register as $value) {
		if(!empty($value)){
			$count ++;
			$textFields = array();
			foreach ($textFields as $DB => $XML) {
				if(!empty($value->$XML)){
					$events["$count"]["$DB"] = $value->{"$XML"}->__toString();
				}else{
					$events["$count"]["$DB"] = '';
				}
			}

			$timeFields = array();

			foreach ($timeFields as $DB => $XML) {
				if(!empty($value->$XML)){
					$events["$count"]["$DB"] = date('G:i',strtotime($value->{"$XML"}->__toString()));
				}else{
					$events["$count"]["$DB"] = '00:00';
				}
			}
			$dateFields = array();

			foreach ($dateFields as $DB => $XML) {
				if(!empty($value->$XML)){
					$events["$count"]["$DB"] = date('Y-m-d',strtotime($value->{"$XML"}->__toString()));
				}else{
					$events["$count"]["$DB"] = '0000-00-00';
				}
			}

			$numberFields = array();

			foreach ($numberFields as $DB => $XML) {
				if(!empty($value->$XML) && (is_numeric($value->{"$XML"}->__toString()) || $DB == 'GADs')) {
					$events["$count"]["$DB"] = $value->{"$XML"}->__toString();
				}else{
					$events["$count"]["$DB"] = '0';
				}
			}

			unset($reason);
			$reasonFields = array();
			$reasonCount = 0;
			foreach ($reasonFields as $DB => $XML) {
				$reasonCount++;
				if($value->{"$XML"} == 'Yes'){
					$reason["$reasonCount"] = "$DB";
				}
			}
			unset($workControl);
			$workControlFields = array();
			$workControlCount = 0;
			foreach ($workControlFields as $DB => $XML) {
				$workControlCount++;
				if($value->{"$XML"} == 'Yes'){
					$workControl["$workControlCount"] = "$DB";
				}
			}

			unset($consider);
			$considerFields = array();
			$considerCount = 0;
			foreach ($considerFields as $XML) {
				$considerCount++;
				if(!empty($value->{"$XML"})){
					$consider["$considerCount"] = $value->{"$XML"}->__toString();
				}else{
					$consider["$considerCount"] = ' ';
				}
			}

			unset($renew);
			$renewFields = array();
			$renewCount = 0;
			foreach ($renewFields as $XML) {
				$renewCount++;
				if(!empty($value->{"$XML"})){
					$renew["$renewCount"] = $value->{"$XML"}->__toString();
				}else{
					$renew["$renewCount"] = ' ';
				}
			}

			$colFields = array();
			foreach ($colFields as $field) {
				if(!empty($$field)){
					$events["$count"]["$field"] = implode(',', $$field);
				}else{
					$events["$count"]["$field"] = ' ';
				}
			}

			if($value->Current_x0020_Status_x0020_on_x0020_Request == 'Approved'){
				$events["$count"]['Stage'] = 'Approve';
			}elseif($value->Current_x0020_Status_x0020_on_x0020_Request == 'Declined by Manager' || $value->Current_x0020_Status_x0020_on_x0020_Request == 'Declined by Trading' ){
				$events["$count"]['Stage'] = 'Decline';
			}elseif($value->Current_x0020_Status_x0020_on_x0020_Request == 'With Trading'){
				$events["$count"]['Stage'] = 'Apply';
			}elseif($value->Current_x0020_Status_x0020_on_x0020_Request == 'With Manager'){
				$events["$count"]['Stage'] = 'Confirm';
			}else{
				$events["$count"]['Stage'] = ' ';
			}
		}
	}

	//setup the placeholders for each individual piece of data
	foreach ($events as $key => $value) {
		foreach ($value as $inc => $raw) {
			$placeholders[":$key$inc"] = $raw;
			$binds[$key][$inc] = ":$key$inc";
		}
	}
	$datafields = array_keys($events[1]);

	//implode the data in each column array to be used in MySQL query
	foreach ($binds as $key => $value) {
		$binds[$key] = "(".implode(',', $value).")";
	}

	//MySQL query setup
	$sql = "INSERT INTO `events` (`".implode('`,`', $datafields)."`) Values ".implode(',', $binds)." ON DUPLICATE KEY UPDATE ID=ID";

	//connect to database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Upload the data
	$pdo->beginTransaction();
	$s = $pdo->prepare($sql);
	try{
		$s->execute($placeholders);
	}
	catch(PDOException $e){
		$error = 'Error uploading to database.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$pdo->commit();
	$_SESSION['messages'] = 'XML successfully imported.';
}
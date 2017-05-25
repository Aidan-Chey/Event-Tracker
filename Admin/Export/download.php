<?php
function array_csv_download($array, $filename = "export.csv", $delimiter=";") { //Not used
	// tell the browser it's going to be a csv file
	header('Content-Type: application/csv');
	// tell the browser we want to save it instead of displaying it
	header('Content-Disposition: attachement; filename="'.$filename.'";');

	// open the "output" stream
	$f = fopen('php://output', 'w');

	foreach ($array as $line) {
		fputcsv($f, $line, $delimiter);
	}
}

include $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

if(isset($_GET['export'])){
	//start mySQL query
	$where = array();
	$placeholders = array();

	//conditional where statment if approved
	if(isset($_GET['approved'])){
		$where[] = "`status` = 'Approve'";
	}

	//conditional where statment if start in future
	if(isset($_GET['onwards'])){
		$where[] = "`start_date` > '".date('Y-m-d')."'";
	}

	$where = implode(' AND ',$where);

	//Retrieve data from DB
	try {
		$sql = "SELECT * FROM `events` WHERE $where ORDER BY `id` DESC";
		$s = $pdo->prepare($sql);
		$s->execute($placeholders);
	} catch (Exception $e) {
		$error = 'Error retrieving records from DB.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	foreach ($s as $line) {
		$rows[] = $line;
	}

	//test if query returned anything
	if(empty($rows)){
		$_SESSION['messages'] = 'No events match criteria.';
		exit();
	}

	//Create XML Object to be written to
	$xml = new SimpleXMLElement('<export/>');

	//setup inputs that are going need to be broken up to display properly
	$toExplode = array('reason','workControl','consider','renew');

	foreach($rows as $line){
		//break up inputs
		foreach($toExplode as $name){
			if(!empty($line["$name"])){
				$line["$name"] = explode(',', $line[$name]);
				foreach ($line["$name"] as $k => $v) {
					$line["$name"]["$k"] = $v;
				}
			}
		}
		//new event record
		$record = $xml -> addChild('record');
		foreach($line as $key => $value){
			//cusom value name if exploded
			if(in_array($key, $toExplode)){
				if(is_array($value)){
					foreach($value as $k => $v){
						if(!empty($v)){
							$record -> $key.$k = $v;
						}
					}
				}
			}elseif(!is_numeric($key) && !empty($value)){
			//add value and it's name to record
			$record -> $key = $value;
			}
		}
	}

	// tell the browser we want to save it instead of displaying it
	header('Content-Disposition: attachement; filename="eventTracker_export_'.date('Y-m-d').'.xml"');
	// tell the browser it's going to be a xml file; removed for older browser compatibility, which only allowed 1 "root element" (export), and the ntent type added "xml version="1.0"" to the front.
	// header("Content-type: text/xml");
	//print xml file to download "page"
	Print($xml->asXML());
}
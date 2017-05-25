<?php
$pageTitle = 'Reports';
$links = array();

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(!userLoggedIn()){
	header("Location: /");
	exit();
}

if(isset($_POST['view']) && !empty($_POST['listSelect'])) {
	header("Location: /Search/?id=".$_POST['listSelect']."&Asked#Results");
	exit();
}

//Determine type of report to generate
if(isset($_GET['Pending'])) $report = "pending";
elseif(isset($_GET['Approved'])) $report = "approved";
elseif(isset($_GET['Changes'])) $report = "changes";
elseif(isset($_GET['Declined'])) $report = "declined";
elseif(isset($_GET['Summary'])){
	$report="summary";
	$links[]='form';
	$links[]='table';
}
elseif(isset($_GET['Length'])){
	$report="length";
	$links[]='form';
}
else{
	header("Location: /");
	exit();
}

include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

//Retrieve Data from DB for fields
switch($report) {
	case 'pending':
		$where = "`status` IN ('apply','confirm')";
		break;
	case 'approved':
		$where = "`status` = 'approve' AND (`start` BETWEEN UNIX_TIMESTAMP() AND UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 6 WEEK)))";
		break;
	case 'declined':
		$where = "`status` = 'decline'";
		break;
	case 'changes':
		$where = "`last_change` > UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 6 WEEK))";
		break;
	case 'length':
		if(!empty($_GET['begin']) && !empty($_GET['end'])) include 'length/length.php';
		break;
}

if(!empty($where)) {
	try{
		$s = $pdo->prepare("SELECT $mysql_event_list FROM `events` WHERE $where ORDER BY `start` ASC");
		$s->execute();
	}
	catch(PDOException $e){
		$error = 'Error retrieving report events.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$events = $s->fetchAll(PDO::FETCH_ASSOC);
	$links[] = 'table';
}else include 'summary/summary.php';

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

if($report == 'summary') include 'summary/summarySelect.html.php';
else if($report == 'length') include 'length/lengthSelect.html.php';

if($report == 'length' && !empty($averages)) include 'length/length.html.php';
else if($report == 'summary' && isset($summary)) include 'summary/summary.html.php';
else if(isset($events)) include 'report.html.php';

if($report == 'length' && !empty($lengthEvents)) include 'length/lengthSearch.html.php';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';

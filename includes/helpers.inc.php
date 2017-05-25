<?php
date_default_timezone_set('NZ');

define('mysql_dateTime','%d %b %Y %r');
define('php_dateTime','Y-m-d H:i');
define('mysql_date','%d %b %Y');
define('php_date','Y-m-d');
define('mysql_time','%r');
define('php_time','H:i');

$mysql_event_list = "
	`id`
	,`type`
	,`status`
	,`location`
	,FROM_UNIXTIME(`start`,'".mysql_date."') AS 'start'
	,FROM_UNIXTIME(`end`,'".mysql_date."') AS 'end'
	,`description`
	,(CASE WHEN `placeholder` = \"t\" THEN 'Yes' ELSE 'No' END) as 'placeholder'
";
$mysql_event_display = "
	`id`
	,`status`
	,`type`
	,`user_id`
	,`location`
	,`description`
	,(SELECT `name` FROM `users` WHERE `id` = `user_id`) as 'requester'
	,`placeholder`
	,`confirmer_checked`
	,`confirmer_feedback`
	,(SELECT `name` FROM `users` WHERE `id` = `confirmer_id`) as 'confirmer_name'
	,`approver_checked`
	,`approver_feedback`
	,(SELECT `name` FROM `users` WHERE `id` = `approver_id`) as 'approver_name'
	,FROM_UNIXTIME(`start`,'".mysql_dateTime."') AS 'start'
	,FROM_UNIXTIME(`end`,'".mysql_dateTime."') AS 'end'
	,FROM_UNIXTIME(`created`,'".mysql_date."') AS 'created'
";
$mysql_draft_list = "
	`id`
	,`type`
	,FROM_UNIXTIME(`saved`,'".mysql_date."') AS 'saved'
	,`location`
	,FROM_UNIXTIME(`start`,'".mysql_date."') AS 'start'
	,FROM_UNIXTIME(`end`,'".mysql_date."') AS 'end'
	,`description`
	,(CASE WHEN `placeholder` = \"t\" THEN 'Yes' ELSE 'No' END) as 'placeholder'
";
$mysql_draft_display = "
	`id`
	,`location`
	,`type`
	,FROM_UNIXTIME(`start`,'".mysql_dateTime."') AS 'start'
	,FROM_UNIXTIME(`end`,'".mysql_dateTime."') AS 'end'
	,`description`
	,`placeholder`
";
$mysql_audit_list = "
	`id`
	,(SELECT `name` FROM `users` WHERE `id` = `user_id` LIMIT 1) as 'name'
	,FROM_UNIXTIME(`ts`,'".mysql_date."') as 'timestamp'
	,CONCAT(`item_id`,' - ',`item`) as 'item'
	,`audits`.`action`
";
$mysql_audit_display = "
	`id`
	,(SELECT `name` FROM `users` WHERE `id` = `user_id` LIMIT 1) as 'name'
	,FROM_UNIXTIME(`ts`,'".mysql_dateTime."') as 'timestamp'
	,CONCAT(`item_id`,' - ',`item`) as 'item'
	,`original`
	,`changed`
	,`action`
";
$mysql_users_list = "
	`id`
	,`name`
	,`email`
	,`role`
	,FROM_UNIXTIME(`joined`,'".mysql_date."') as 'joined'
	,(CASE WHEN `subscribed` > 0 THEN 'Yes' ELSE 'No' END) as 'subscribed'
	,(CASE WHEN `verified` > 0 THEN 'Yes' ELSE 'No' END) as 'verified'
";

$mysql_calendar = "
	`id`
	,`status`
	,`type`
	,(SELECT `name` FROM `users` WHERE `id` = `user_id`) as 'requester'
	,`location`
	,FROM_UNIXTIME(`start`,'".mysql_dateTime."') AS 'start'
	,FROM_UNIXTIME(`end`,'".mysql_dateTime."') AS 'end'
	,`placeholder`
	,`description`
";

include $_SERVER['DOCUMENT_ROOT'].'/includes/status.php';

//manipulates the input into a format for use with the table HTML
function createTableData($input) {
	$output = ['rows' => $input];
	foreach ($output['rows'] as $num => $row) {
		if(!empty($output['rows'][$num]['status'])) $output['rows'][$num]['status'] = status($row['status'],array('placeholder'=>$row['placeholder']));
	}
	return $output;
}

//passes on the input text to the html function
function htmlout($input){
	$output = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
	echo html_entity_decode($output, ENT_QUOTES, 'UTF-8');
}

//shortcut variable checker
function varEquals($var,$input) {
	if(!empty($var) && $var == $input) {
		return TRUE;
	}
	return FALSE;
}

function requStar($form) {
	if($form == 'edit') echo '<span style="color:red;">*</span>';
}

//Generates a random string of numbers and letters the size specified in the call
function randomString( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen( $chars );
	$str ='';
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
}

function stripNonAlpha($string) {
	return preg_replace("/[^a-z]/i","",$string);
}

//Default date format
function date_out($input){
	if(is_array($input)) $input = $input['date'];
	if(!is_numeric($input)) $input = strtotime($input);
	echo date('j F Y',$input);
}

//Default time format
function time_out($input){
	if(is_array($input)) $input = $input['time'];
	if(!is_numeric($input)) $input = strtotime($input);
	echo date('g:i a',$input);
}

//Default datetime format
function datetime_out($input){
	if(!is_numeric($input)) $input = strtotime($input);
	echo date('j F Y g:i a',$input);
}

function checktime($hour, $min, $sec) {
	if ($hour < 0 || $hour > 23 || !is_numeric($hour)) {
		return false;
	}
	if ($min < 0 || $min > 59 || !is_numeric($min)) {
		return false;
	}
	if ($sec < 0 || $sec > 59 || !is_numeric($sec)) {
		return false;
	}
	return true;
}


//Calculate event Duration
function duration($start_date,$start_time,$Isolation,$finish_date,$finish_time,$deisolation){
	$start = date('Y-m-d H:i',(strtotime($start_date.' '.$start_time)+strtotime("+$isolation hours")));
	$finish = date('Y-m-d H:i',(strtotime($finish_date.' '.$finish_time)+strtotime("+$deisolation hours")));
}

<?php //code snippet constructing the where statement for retrieveing events
//Calculates the timespan the calendar should use
include 'timespanCalculation.php';
$timespan = timespan();

//Create MySQL query to retireve events
$placeholders = array(':firstDate'=>$timespan['start'],':lastDate'=>$timespan['end']);
$where = array(
	" !(`end` <= :firstDate) "
	," !(`start` >= :lastDate) "
	," `status` != 'apply' "
	," `status` IS NOT NULL "
);

//Retrieve list of locations
include $_SERVER['DOCUMENT_ROOT'].'/includes/locations.inc.php';
$locations = getLocations( implode(' AND ',$where),$placeholders );
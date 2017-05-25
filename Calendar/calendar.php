<?php //Script to handle retriving events for calendar

//Colours used in the calendar
$colours = array(
	'blue' => 'hsl(219,100%,67%)'
	,'orange' => 'hsl(25,100%,66%)'
	,'pink' => 'hsl(317,62%,68%)'
	,'green' => 'hsl(114,73%,62%)'
	,'red' => 'hsl(0, 79%, 58%)'
	,'yellow' => 'hsl(60, 87%, 50%)'
);

$states = array(
	'declined' => $colours['red']
	,'confirmed' => $colours['yellow']
	,'placeholder' => $colours['orange']
	,'approved' => $colours['green']
);

//Array of day abreviations to use in the calendar
$weekDays=array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

//Create array of stations to pick from for dropdown
$infoArray = array('Full_Portfolio');
if(!empty($locations)){
	foreach ($locations as $value) {
		array_push($infoArray,$value['name']);
	}
}

//code snippet constructing the where statement
include 'eventWhere.php';

//Create array of each month in the calendar timespan
for ($i=$timespan['start']; $i < strtotime(' + 1 month',$timespan['end']); $i = strtotime(' + 1 month',$i)) {
	$monthRows[date('Y-m',$i)] = null;		//Number of rows in the calendar month
	$events[date('Y-m',$i)] = array();		//Events separated by month
}

//Sort date ordered array
ksort($events);

//Add where statments to MySQL query based off requested calendar information
if(!empty($_GET['info']) && in_array($_GET['info'],$locations)){
	$where[] = '`location` = :location';
	$placeholders[':location'] = $_GET['info'];
}

$where = implode(' AND ',$where);

//Connect to Database
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

//Retrieve events from DB
$s = $pdo->prepare(
	"SELECT $mysql_calendar
	FROM `events`
	WHERE $where
	ORDER BY `start` ASC
	, `end` DESC
");

try{
	$s->execute($placeholders);
}
catch (PDOException $e){
	$error = 'Error retrieving calendar data.'.$e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
//sort events into arrays
foreach($s->fetchAll(PDO::FETCH_ASSOC) as $value){

	if($value['status'] == 'decline') $value['colour'] = $states['declined'];
	elseif($value['status'] == 'approve') $value['colour'] = $states['approved'];
	elseif($value['placeholder'] == 't') $value['colour'] = $states['placeholder'];
	else $value['colour'] = $states['confirmed'];

	//Event information to be added to the calendar
	$id = $value['id'];
	unset($value['id']);
	$event = $value;
	$event['duration'] = ceil((strtotime($value['end']) - strtotime($value['start'])) / 86400 + 1);

	//Add unit to events and calender units arrays
	//Calendar units array collects units to be used as units on the axis of the monthly calendar
	if(!isset($calendarLocations)){
		$calendarLocations=array();
	}
	if(!empty($value['location'])){
		if(!in_array($value['location'], $calendarLocations)){
			$calendarLocations[] = $value['location'];
		}
	}

	//Calculate the number of rows needed for each month based off the events that will be occuring in that month
	foreach ($monthRows as $month => $p) {

		//Collect event start and end dates for compaction later on if not associated event
		if($value['type'] != 'associated'){

			//If the end date is within current selected month add to variable
			if($month == date('Y-m',strtotime($value['end']))) { $eventEnd[] = $value['end']; }

			//If the start date is within current selected month add to variable
			if($month == date('Y-m',strtotime($value['start']))) { $eventStart[] = $value['start']; }
		}
		//Adding rows for events that have already started or will start in the month and have yet to end
		//If the event dosn't start after the end of the month and dosn't end before the begining of the month
		if(!(strtotime($value['start']) > strtotime(date('Y-m-t',strtotime($month)))) && !(strtotime($value['end']) < strtotime($month))) {

			//Add row to month if not associated events
			if($value['type'] != 'associated') { $monthRows[$month] ++; }

			//Add event to Month
			$events[$month][$id] = $event;
		}
	}
	unset($event,$id);
}

//Cycle through each month to remove unessesary rows
if(!empty($eventEnd) && !empty($eventStart)){
	foreach ($monthRows as $month => $p) {
		foreach ($eventEnd as $kf => $f) {
			//If the end date is in selected month
			if($month == date('Y-m',strtotime($f))) {
				foreach ($eventStart as $ks => $s) {
					//If start date is in selected month and start is after end
					if($month == date('Y-m',strtotime($s)) && $s > $f) {
						//Remove a row from the month and unset the start and end date
						$monthRows[$month] --;
						unset($eventEnd[$kf],$eventStart[$ks]);
						break;
					}
				}
			}
		}
	}
}

//Sort units and remove waste entry in array
if(isset($calendarLocations) && is_array($calendarLocations)){
	sort($calendarLocations);
}else{
	//Return to home screen as no events were found
	$_SESSION['messages'] = 'Either no events available or not enough to form a calendar.';
	header("Location: /Calendar");
	exit();
}
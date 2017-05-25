<?php //Calculates the timespan the calendar should use, returns a 2 element array of keys 'start' and 'end'
function timespan() {
	$beginning = new DateTime('first day of this month');
	$ending = new DateTime($beginning->format('Y-m-d'));
	$ending->modify('+12 month');

	//Set two dates for beinging and end of calendar timespan
	$firstDate = $beginning->getTimestamp();
	$lastDate = $ending->getTimestamp();

	return array('start'=>$firstDate,'end'=>$lastDate);
}

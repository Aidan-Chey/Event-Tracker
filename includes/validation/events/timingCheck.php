<?php
if(!empty($_POST['start_date']) && !empty($_POST['start_time']) && !empty($_POST['finish_date']) && !empty($_POST['finish_time'])){
	$starDateTime = implode(' ',$_POST['start']);
	$endDateTime = implode(' ',$_POST['end']);

	//Start date is after current date
	if(strtotime($starDateTime) <= strtotime(date("Y-m-d H:i:s"))){
		$errors['general'] = ' Please make sure the start date and time is after today.';
	}

	//Finish Date after Start Date
	if(strtotime($starDateTime) >= strtotime($endDateTime)){
		$errors['general'] = ' Please make sure the end date and time is after the start date and time.';
	}
}
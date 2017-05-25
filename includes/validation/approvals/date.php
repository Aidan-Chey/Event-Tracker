<?php
//Validate date
if(empty($_POST['date'])){
	$errors['date'] = " Please enter a date";
}
else{
	list($year, $month, $day) = explode('-', $_POST['date']);
	if(!checkdate($month, $day, $year)){
		$errors['date'] = " Please enter a valid date";
	}
}
<?php
//Validate end date and time
if(empty($_POST['end']['date'])) {
	$errors['end']['date'] = 'An end date is required.';
}

if(empty($_POST['end']['time'])) {
	$errors['end']['time'] = 'An end time is required.';
}

if(empty($errors['end'])) {
	if(empty(strtotime($_POST['end']['date']))) {
		$errors['end']['date'] = ' Please enter a valid end date.';
	}
	if(empty(strtotime($_POST['end']['time']))) {
		$errors['end']['time'] = ' Please enter a valid end time.';
	}
}
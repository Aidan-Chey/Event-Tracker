<?php
//Validate start date and time
if(empty($_POST['start']['date'])) {
	$errors['start']['date'] = ' Please enter a start date.';
}

if(empty($_POST['start']['time'])) {
	$errors['start']['time'] = ' Please enter a start time.';
}

if(empty($errors['start'])){
	if(empty(strtotime($_POST['start']['date']))) {
		$errors['start']['date'] = ' Please enter a valid start date.';
	}
	if(empty(strtotime($_POST['start']['time']))) {
		$errors['start']['time'] = ' Please enter a valid start time.';
	}
}
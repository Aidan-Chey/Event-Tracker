<?php
//Validate location
if(empty($_POST['location'])) {
	$errors['location'] = ' Please enter a description.';
}
elseif(strlen($_POST['location']) < 1) {
	$errors['location'] = ' Plase use a longer description (min 1 characters).';
}
elseif(strlen($_POST['location']) > 25){
	$errors['location'] = ' Please use a shorter description (max 25 characters).';
}
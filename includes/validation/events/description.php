<?php
//Validate descripton
if(empty($_POST['description'])) {
	$errors['description'] = ' Please enter a description.';
}
elseif(strlen($_POST['description']) < 5) {
	$errors['description'] = ' Plase use a longer description (min 5 characters).';
}
elseif(strlen($_POST['description']) > 5000){
	$errors['description'] = ' Please use a shorter description (max 5000 characters).';
}
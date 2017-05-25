<?php
//Validate requester
if(empty($_POST['requester'])) {
	$errors['requester'] = ' Please enter a requester.';
}
elseif(strlen($_POST['requester']) < 1){
	$errors['requester'] = ' Please enter a longer name (min 2 characters).';
}
elseif(strlen($_POST['requester']) > 25){
	$errors['requester'] = ' Please enter a shorter name (max 25 characters).';
}
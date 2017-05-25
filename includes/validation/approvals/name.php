<?php
//Validate name
if(empty($_POST['name'])){
	$errors['name'] = " Please enter a name";
}
elseif(strlen($_POST['name']) > 25){
	$errors['name'] = " Please enter a shorter name (max 25 characters)";
}
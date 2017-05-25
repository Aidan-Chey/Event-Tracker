<?php
//Check user ID
if(empty($user['id'])){
	$errors['general'] = " User Id not found.";
}
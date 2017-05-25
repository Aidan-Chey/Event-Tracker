<?php
//Validate Feedback
if(isset($_POST['decline']) && empty($_POST['feedback'])){
	$errors['feedback'] = " Please enter feedback";
}
elseif(!empty($_POST['feedback'])){
	if(strlen($_POST['feedback']) < 5){
		$errors['feedback'] = " Please enter a longer feedback (min 5 characters)";
	}
	elseif(strlen($_POST['feedback']) > 5000){
		$errors['feedback'] = " Please enter a shorter feedback (max 5000 characters)";
	}
}
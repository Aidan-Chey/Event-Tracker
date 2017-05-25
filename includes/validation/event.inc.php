<?php
if(isset($_POST['submit'])){
	if(!empty($type) && $type == 'Associated'){
	}

	//Validate location
	include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/events/location.php';

	//Validate start
	include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/events/start.php';

	//Validate end
	include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/events/end.php';

	//Check Timing is appropriate
	include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/events/timingCheck.php';

	//Validate description
	include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/events/description.php';
}
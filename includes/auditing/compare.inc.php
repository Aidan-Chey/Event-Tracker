<?php //Function to compare the new values to the original to determine what was changed
function auditCompare($new,$original) {
	if(!is_array($new)) {
		$error = 'Error, new fields not array for audit comparison. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return false;
	}

	$output = array();

	if(!empty($original)) {
		if(!is_array($original)) {
			$error = 'Error, original fields not array for audit comparison. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			return false;
		}

		foreach ($original as $key => $value) {
			if(array_key_exists($key, $new)) {
				if($new["$key"] != $value){
					$output['original']["$key"] = $value;
					$output['changed']["$key"] = $new["$key"];
				}
			}
		}
	}else{
		foreach ($new as $key => $value) {
			$output['changed']["$key"] = $value;
		}
	}

	return $output;
}
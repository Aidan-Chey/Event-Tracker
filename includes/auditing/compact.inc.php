<?php //Function to compact an associative array into a readable format for uploading to a database
function auditCompact($input) {
	$output = array();
	if (is_array($input)) {
		foreach ($input as $key => $value) {
			$output[] = "[$key]=>[$value]";
		}
		return implode(',',$output);
	}
	$error = 'Error, input not array for audit compression. ';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	return false;
}
<?php //Function to retrieve the locations of events, takes a SQL where statment
function getLocations($where,$placeholders) {
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	if(empty($where)){
		$where = "TRUE";
	}

	try {
		$s=$pdo->prepare("SELECT `location` FROM `events` WHERE $where ORDER BY `location` ASC");
		$s->execute($placeholders);
	} catch (PDOException $e) {
		$errors = 'Error retrieving event location.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	$output = array();

	foreach ($s->fetchAll(PDO::FETCH_COLUMN) as $key => $value) {
		if(!in_array($value,$output)){
			$output[] = $value;
		}
	}

	return $output;
}
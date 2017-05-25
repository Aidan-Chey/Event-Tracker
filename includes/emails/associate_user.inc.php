<?php //Function to retrieve associated event's user id
function associateuser($id) {
	if(!empty($id)) {
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
		try {
			$s=$pdo->prepare("SELECT `user_id` FROM `events` WHERE `assoc_id` = :id");
			$s->execute(array(':id' => $id));
		} catch (PDOException $e) {
			$error = 'Error retreiving user id for associated events. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		$output = array();
		foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $value) {
			if(!in_array($value,$output)) {
				$output[] = $value;
			}
		}
		return $output;
	}else{
		return false;
	}
}
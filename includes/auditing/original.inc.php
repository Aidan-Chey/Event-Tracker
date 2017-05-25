<?php //Function to retrieve the original values of the changed event for comparision
function getOriginal($id,$item) {
	if (empty($id)) {
		$error = 'Error, ID empty when retrieving original entry. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return false;
	}
	if(empty($item)) {
		$error = 'Error, item empty when retrieving original entry. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return false;
	}

	switch ($item) {
		case 'event':
			$table = 'events';
			break;
		case 'user':
			$table = 'users';
			break;
	}

	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
	try {
		$s=$pdo->prepare("SELECT * FROM `$table` WHERE `id` = :id Limit 1");
		$s->execute(array(':id' => $id));
	} catch (PDOException $e) {
		/*$error = 'Error retrieving original entry for auditing. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';*/
		return false;
	}
	if($s->rowCount() >0) return $s->fetchAll(PDO::FETCH_ASSOC)[0];
	//Why do we grab any old line from tabe?
/*	else{
		try {
			$s=$pdo->prepare("SELECT * FROM `$table` Limit 1");
			$s->execute();
		} catch (PDOException $e) {
			$error = 'Error retrieving an entry for auditing comparision. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			return false;
		}
		return $s->fetchAll(PDO::FETCH_ASSOC)[0];
	}*/
}
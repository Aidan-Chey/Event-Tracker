<?php //Function to retrieve user ids
function userIds($users) {
	if(!empty($users)) {
		if(count($users)>1){
			$array = implode("','", $users);
		}else{
			$array = $users[0];
		}
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
		try {
			$s=$pdo->prepare("SELECT `id` FROM `users` WHERE `name` IN ('$array')");
			$s->execute();
		} catch (PDOException $e) {
			$error = 'Error retreiving user ids for emails. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		$output = array();
		foreach ($s->fetchAll(PDO::FETCH_COLUMN) as $value) {
			if(!in_array($value,$output)) {
				$output[] = $value;
			}
		}
		return $output;
	}else{
		return false;
	}
}
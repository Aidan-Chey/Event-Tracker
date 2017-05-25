<?php //Function to retrieve the emails of a array of users
function userEmails($input) {
	if(!empty($input)){

	//Separate inputs into IDs and Names
		$user_ids = array();
		$names = array();
		if(is_array($input)){
			foreach ($input as $value) {
				if(is_numeric($value)) {
					$user_ids[] = $value;
				}else if(!empty($value)) {
					$names[] = $value;
				}
			}
		}else{
			if(is_numeric($input)) {
				$user_ids[] = $input;
			}else if(!empty($input)) {
				$names[] = $input;
			}
		}


	//Compact arrays into string for query
		if (is_array($user_ids)) {
			$user_ids = implode("', '", $user_ids);
		}
		if (is_array($names)) {
			$names = implode("', '", $names);
		}

	//Compact arrays for where statements
		if(!empty($user_ids)) {
			$wheres[] = "`id` IN ('$user_ids')";
		}
		if(!empty($names)) {
			$wheres[] = "`name` IN ('$names')";
		}

	//Compact where statements for MySQL query
		if(is_array($wheres)){
			$where = implode(' AND ',$wheres);
		}else{
			$where = $wheres;
		}


	//Retrieve emails of supplied ids and names
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
		try {
			$s=$pdo->query("SELECT `email` FROM `users` WHERE $where");
			$s->execute();
		} catch (PDOException $e) {
			$error = 'Error retreiving recipient emails. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		$output = array();
		foreach ($s->fetchAll(PDO::FETCH_COLUMN) as $value) {
			if(!in_array($value, $output)) {
				$output[] = $value;
			}
		}

		return $output;
	}
}
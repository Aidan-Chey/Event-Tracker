<?php
//Function to retrieve list of users
function getUsers($fields,$where,$limit) {
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	if(!empty($fields) && is_array($fields)){
		$sql = "SELECT `".implode('`,`',$fields)."` FROM `users` ";
	}else{
		$sql = "SELECT * FROM `users` ";
	}

	if(!empty($where) && is_array($where)){
		$sql .= " WHERE true";
		$placeholders = array();
		foreach ($where as $field => $entry) {
			if(is_array($entry)){
				foreach ($entry as $operator => $value) {
					$sql .= " AND $field $operator :$field";
					$placeholders[":$field"] = $value;
				}
			}
		}
	}

	if(!empty($limit) && is_int($limit)){
		$sql .=" LIMIT $limit ";
	}

	try {
		$s=$pdo->prepare($sql);
		if (!empty($placeholders)) {
			$s->execute($placeholders);
		}else{
			$s->execute();
		}
	} catch (PDOException $e) {
		$error = 'Error retrieving users using function getUsers. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$output = $s->fetchAll(PDO::FETCH_ASSOC);

	if (count($output) == 1) {
		return $output[0];
	}
	return $output;
}
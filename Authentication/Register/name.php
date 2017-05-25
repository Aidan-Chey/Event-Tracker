<?php
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Validate Name
	if(empty($_POST['name'])){
		echo urlencode("Please enter a display name.");
	}
	elseif(strlen($_POST['name']) > 25){
		echo urlencode("Please enter a shorter name (max 25 characters).");
	}
	else{
		//check name is not taken
		try{
			$sql = "SELECT COUNT(*) FROM `users` WHERE `name` = :name LIMIT 1";
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['name']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error searching for name. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		$row = $s->fetch();
		if ($row[0] > 0 || $_POST["name"] == "Admin" || $_POST["name"] == "Webmaster"){
			echo urlencode("Please enter another name, name already exists.");
		}/*else{
			echo "&#10004";
		}*/
	}
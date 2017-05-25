<?php
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Validate Email
	if(empty($_POST['email'])){
		echo urlencode(" Please enter a email.");
	}
	elseif(strlen($_POST['email']) > 100){
		echo urlencode(" Please enter a shorter email (max 100 characters).");
	}
	elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		echo urlencode(" Please enter a valid email.");
	}
	else{
		//check email is not taken
		try{
			$sql = "SELECT COUNT(*) FROM `users` WHERE `email` = :email LIMIT 1";
			$s = $pdo->prepare($sql);
			$s->bindValue(':email', $_POST['email']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error searching for email. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		$row = $s->fetch();
		if ($row[0] > 0 || $_POST["email"] == "webmaster@eventTracker.aidancheyd.info"){
			echo urlencode("Please enter another email, account already exists.");
		}/*else{
			echo "&#10004";
		}*/
	}
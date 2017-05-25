<?php
$pageTitle = 'Register';
$javas = array('registration_valid');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

//Registration Attempts
if(isset($_POST['register'])){
	//Connect to Database
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';

	//Validate Email
	if(empty($_POST['email'])){
		$errors['email'] = " Please enter a email.";
	}
	elseif(strlen($_POST['email']) > 100){
		$errors['email'] = " Please enter a shorter email (max 100 characters).";
	}
	elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$errors['email'] = " Please enter a valide email.";
	}
	else{
		//check email is not taken
		try{
			$sql = "SELECT '' FROM `users` WHERE `email` = :email LIMIT 1";
			$s = $pdo->prepare($sql);
			$s->bindValue(':email', $_POST['email']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error searching for email. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		if($s->rowCount() >0 || strtolower($_POST["email"]) == "webmaster@eventTracker.aidancheyd.info") {
			print_r($s->fetchAll());
			$errors['email'] = "Please enter another email, account already exists.";
		}
	}

	//Validate Name
	if(empty($_POST['name'])){
		$errors['name'] = "Please enter a display name.";
	}
	elseif(strlen($_POST['name']) > 25){
		$errors['name'] = "Please enter a shorter name (max 25 characters).";
	}
	else{
		//check name is not taken
		try{
			$sql = "SELECT '' FROM `users` WHERE `name` = :name LIMIT 1";
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['name']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error searching for name. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		if ($s->rowCount() > 0 || strtolower($_POST["name"]) == "admin" || strtolower($_POST["name"]) == "webmaster"){
			$errors['name'] = "Please enter another name, name already exists.";
			print_r($s->fetchAll());
		}
	}

	//Validate Passwords
	if(empty($_POST['password'])){
		$errors['password'] = "Please enter a password.";
	}
	elseif(strlen($_POST['password']) > 72){
		$errors['password'] = "Please enter a shorter password (max 72 characters)";
	}
	elseif($_POST['password'] != $_POST['password2']){
		$errors['password'] = "Your passwords were not the same.";
	}

	//If no errors
	if(empty($errors)){
		//Connect to Database
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

		$pdo->beginTransaction();

		//Insert Information into DB
		try{
			$sql = 'INSERT INTO `users` SET `email` = :email, `name` = :name, `joined` = :now';
			$s = $pdo->prepare($sql);
			$s->execute(array(
				':email'=>$_POST['email']
				,':name'=>$_POST['name']
				,':now'=>strtotime('now')
			));
		}
		catch (PDOException $e){
			$pdo->rollback();
			$error = 'Error adding submitted user. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		$user_id = $pdo->lastInsertId();
		if (!empty($_POST['password'])){
			//encrypt password
			$password = crypt($_POST['password'],pSalt);

			//Update account with password
			try{
				$sql = 'UPDATE `users` SET `password` = :password WHERE `id` = :id';
				$s = $pdo->prepare($sql);
				$s->execute(array(
					':password'=>$password,
					':id'=>$user_id
				));
			}
			catch (PDOException $e){
				$pdo->rollback();
				$error = 'Error setting user password. ';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}

			$pdo->commit();

			//Success message
			$_SESSION['messages'] = " Account created.";
		}
		//Send email and load verification code
		include_once 'registEmail.inc.php';

		if(registEmail($_POST['email'])){
			$_SESSION['messages'] = " Verification email sent.";
			header("Location: /Authentication/VerifyEmail");
			exit();
		}else{
			$_SESSION['messages'] = " Failed to send verification email, contact an administrator to retrieve your code.";
		}
	}
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include "register.html.php";

unset($_SESSION['messages']);
?>
</body>
</html>
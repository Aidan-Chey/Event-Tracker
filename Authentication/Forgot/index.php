<?php
$pageTitle = 'Forgot';
$javas = array('registration_valid');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

//Forgot Password
if(isset($_POST['forgot'])){
	//Connect to Database
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';

	//Validate Email
	if(empty($_POST['email'])){
		$errors['email'] = "Please enter a email.";
	}
	elseif(strlen($_POST['email']) > 100){
		$errors['email'] = "Please enter a shorter email (max 100 characters).";
	}
	elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$errors['email'] = "Please enter a valide email.";
	}
	else{
		$_POST['email'] = strtolower($_POST['email']);
		//Compare submitted Email
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
		try{
			$sql = 'SELECT COUNT(*) FROM `users` WHERE `email` = :email AND `name` != "[Removed]" LIMIT 1';
			$s = $pdo->prepare($sql);
			$s->bindValue(':email', $_POST["email"]);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error searching for Email.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		$row = $s->fetch();
		if ($row[0] == 0 || $_POST["email"] == "webmaster@eventtracker.aidancheyd.info" || $_POST["email"] == "admin@eventtracker.aidancheyd.info"){
			$errors['email'] = " Email does not exist.";
		}
	}

	//If no errors
	if(empty($errors)){
		include_once 'forgotEmail.inc.php';
		if(forgotEmail($_POST["email"])) {
			$_SESSION['messages'] = " Verification email sent.";
			header("Location: /Authentication/VerifyEmail/?code");
			exit();
		} else {
			$_SESSION['messages'] = " Failed to send verification email, contact an administrator to retrieve your code.";
		}
	}
}

//Change Password
if(isset($_POST['reset']) && !empty($_SESSION['reset'])){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Validate Password
	if(empty($_POST['password'])){
		$errors['password'] = "Please enter a password.";
	}
	elseif(strlen($_POST['password']) > 72){
		$errors['password'] = "Please enter a shorter password (max 72 characters)";
	}

	//If no errors
	if(empty($errors)){
		//encrypt password
		$password = crypt($_POST['password'],pSalt);

		//update account with new password
		try{
			$sql = 'UPDATE `users` SET `password` = :password WHERE `verify_code` = :code AND `verify_purpose` = "forgot"';
			$s = $pdo->prepare($sql);
			$s->bindValue(':password', $password);
			$s->bindValue(':code', $_SESSION['reset']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error setting user password.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		//success message
		$_SESSION['messages'] = " Password changed.";
		// unset($_SESSION['reset']);
		header("Location: /Authentication/Login/");
		exit();
	}
}
//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

if(!empty($_SESSION['reset'])){
	include 'reset.html.php';
}else{
	include "forgot.html.php";
}
unset($_SESSION['messages']);
?>
</body>
</html>
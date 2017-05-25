<?php
$pageTitle = 'Login';

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

//Login Attempts
if (isset($_POST['login'])){

	//Login Count
	if(isset($_COOKIE['logCount']) && $_COOKIE['logCount'] > 4){
		$errors['general'] = 'Too many login attempts, try agian another time!';
	}

	//Validate Email
	if(empty($_POST['email'])){
		$errors['email'] = 'Please enter a email';
	}
	elseif(strlen($_POST['email']) > 100){
		$errors['email'] = 'Please enter a shorter email (max 100 characters)';
	}
	elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$errors['email'] = 'Please enter a valid email';
	}

	//Validate Password
	if(empty($_POST['password'])){
		$errors['password'] = 'Please enter a password';
	}
	if(strlen($_POST['password']) > 72){
		$errors['password'] = 'Please enter a shorter password (max 72 characters)';
	}

	//Run if no errors
	if(empty($errors)){
		//encrypt password
		$password = crypt($_POST['password'],pSalt);

		//Check _POSTed info agianst database
		if (databaseContainsUser($_POST['email'], $password)){
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['domain'] = $_SERVER['HTTP_HOST'];
			$_SESSION['user']['email'] = $_POST['email'];
			$_SESSION['user']['password'] = $password;

			/*if(userHasRole('Removed')){
				unset($_SESSION['loggedIn']);
				unset($_SESSION['user']['email']);
				unset($_SESSION['user']['password']);
				$_SESSION['messages']='Account removed, contact an administrator about reactivating account.';*/

			setcookie('logCount', "", time() -3600);
			$_SESSION['messages']=' Logged in.';
			header("Location: /");
			exit();

		}
		//If not in Database, +1 login count, unset $_session and error
		else{
			if(isset($_COOKIE['logCount'])){
				$_COOKIE['logCount'] ++;
			}
			else{
				$_COOKIE['logCount'] = 1;
			}
			setcookie('logCount', $_COOKIE['logCount'], time() + 3600);
			unset($_SESSION['loggedIn']);
			unset($_SESSION['domian']);
			unset($_SESSION['user']['email']);
			unset($_SESSION['user']['password']);
			$errors['general'] = 'The specified email address or password was incorrect.';
		}
	}
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include "login.html.php";

unset($_SESSION['messages']);
?>
</body>
</html>
<?php
$pageTitle = 'Verify Email';

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(!empty($_GET['resend']) && !empty($_SESSION['user']['email'])) {
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//Retrieve verification code
	try {
		$s = $pdo->prepare("SELECT `verify_time`, `verify_purpose`, `verified` FROM `users` WHERE `email` = :email LIMIT 1");
		$s->bindValue(':email', $_SESSION['user']['email']);
		$s->execute();
	} catch (PDOException $e) {
		$error = 'Error finding account. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	if($s->rowCount() > 0){
		$row = $s->fetchAll(PDO::FETCH_ASSOC)[0];
		switch ($row['verify_purpose']) {
			case 'register':
				include_once $_SERVER['DOCUMENT_ROOT'].'/Authentication/Register/registEmail.inc.php';
				registEmail($_SESSION['user']['email']);
				break;
			case 'forgot':
				include_once $_SERVER['DOCUMENT_ROOT'].'/Authentication/Forgot/forgotEmail.inc.php';
				forgotEmail($_SESSION['user']['email']);
				break;
		}
		$_SESSION['messages'] = " A new code has been sent to the associated email address.";
	}else{
		$_SESSION['messages'] = " No account with this code found.";
	}
	//Run appropriate send email code
}else
//when a verification attempt is made
if(!empty($_GET['code'])){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//check code is accepted by any account
	try{
		$s = $pdo->prepare("SELECT `verify_time`, `verify_purpose`, `verified` FROM `users` WHERE `verify_code` = :code LIMIT 1");
		$s->bindValue(':code', $_GET['code']);
		$s->execute();
	}
	catch (PDOException $e){
		$error = 'Error finding account. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	if($s->rowCount() > 0){
		$row = $s->fetchAll(PDO::FETCH_ASSOC)[0];
		print_r($row);
		if(!($row['verify_time'] > strtotime('now'))) {
			$_SESSION['messages'] = " Sorry, that code has expired; please try agian.";
		}
		elseif( $row['verify_purpose'] == 'forgot') {
			//Redirect to password reset
			$_SESSION['reset'] = $_GET['code'];
			$_SESSION['messages'] = " Account email successfully verified.";
			header("location: /Authentication/Forgot/");
			exit();
		}
		elseif( $row['verified'] == 1 ) {
			$_SESSION['messages'] = " Account already verified.";
		}
		elseif( $row['verify_purpose'] == 'register' ) {
			//update account with code to verify
			try{
				$s = $pdo->prepare("UPDATE `users` SET `verified` = '1' WHERE `verify_code` = :code AND `verified` = '0' LIMIT 1");
				$s->bindValue(':code', $_GET['code']);
				$s->execute();
			}
			catch (PDOException $e){
				$error = 'Error verifying account. ';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}

			//success message & redirect to login
			$_SESSION['messages'] = " Account email successfully verified.";
			header("location: /Authentication/Login/");
			exit();
		}
		else{
			$_SESSION['messages'] = " Error occured, this code does not have a purpose.";
		}
	}else{
		$_SESSION['messages'] = " No account with this code found.";
	}
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'verifyEmail.html.php';

unset($_SESSION['messages']);
?>
</body>
</html>
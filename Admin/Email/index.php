<?php
$pageTitle = 'Email Subscribers';
$links = array('form');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

//Update user details
if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
}

if (!userHasRole('admin')){
	header('Location: /?Permissions');
}

//If email request sent
if(isset($_POST['email'])){
	//Validate Subject
	if(empty($_POST['subject'])){
		$errors['subject'] = 'Please enter a subject';
	}
	elseif(strlen($_POST['subject']) < 5){
		$errors['subject'] = 'Please enter a longer subject';
	}
	elseif(strlen($_POST['subject']) > 100){
		$errors['subject'] = 'Please enter a shorter subject';
	}
	//Validate Message
	if(empty($_POST['message'])){
		$errors['message'] = 'Please enter a message';
	}
	elseif(strlen($_POST['message']) < 20){
		$errors['message'] = 'Please enter a longer message';
	}
	elseif(strlen($_POST['message']) > 3000){
		$errors['message'] = 'Please enter a shorter message';
	}

	if(empty($errors)){
		//Connect to Database
		require_once $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

		require_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';

		//Update user details
		if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
			include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
		}

		//Retrieve account emails
		try{
			$sql = "SELECT `id`, `email` FROM `users` WHERE `subscribed` = '1' AND `name` <> '[Removed]'";
			$s = $pdo->prepare($sql);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error retrieving emails for emailing system.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		$pdo->beginTransaction();
		$unsents = 0;
		foreach ($s as $value) {
			if(empty($value['Email'])){
				$_SESSION['messages'] = ' No subscribers were found.';
				header("Location: /Admin/Email/");
				exit();
			} else {
				$count[] = $value['Id'];
				$unsubscribe = md5($value['Email'].randomString(10));
				$to = htmlentities($value['Email']);
				$subject = htmlentities($_POST['subject']);
				$message = htmlentities($_POST['message']);
				$HtmlMessage = "<html>
					<body style='font-family:Tahoma,sans-serif;padding:0;margin:0;background-color:hsl(0,0%,95%);'>";
				$HtmlMessage .= "<a href='http://".$_SERVER['name']."' target='_blank' style='display:block;text-decoration:none;color:hsl(0,0%,98.5%);background-color:hsl(28.5,83.6%,54.5%);vertical-align:middle;'>
						<h1 style='text-align:center;padding:.3em;font-size:1.8em;'>Event Tracking System</h1>
					</a>";
				$HtmlMessage .= "<div style='max-width:960px;margin:.5em 4px;'>".$_POST['message']."</div>";
				$HtmlMessage .= "<hr>
					<div style='text-align:center;margin-top:1em;'>
						Message sent via Event Tracker emailer at http://".$_SERVER['SERVER_NAME']." to all subscribers by Admin ".$_SESSION['user']['name']."<br>If you no longer wish to receive these emails
						<a target='_blank' href='http://".$_SERVER['SERVER_NAME']."/?Unsubscribe=".$unsubscribe."'>
							click this <b>unsubscribe</b> link
						</a>
					</div>
					<hr>";
				$HtmlMessage .= "</body>
					</html>";

				$PlainMessage ="Event Tracking System - (This message is in plain text becuase your email system does not allow HTML emails)\r\n\r\n\r\n".$message."\r\n\r\n\r\nMessage sent via Event Tracker emailer at http://www.".$_SERVER['SERVER_NAME']." to all subscribers by Admin ".$_SESSION['user']['name']."\r\n\r\nIf you no longer wish to receive these emails use this link: http://".$_SERVER['SERVER_NAME']."/?Unsubscribe=".$unsubscribe;

				if(send_email($to,$subject,$HtmlMessage,$PlainMessage)){
					//Update Account's unsubscribe code
					try{
						$sql = "UPDATE `users` SET `Unsubscribe` = '$unsubscribe' WHERE `Email` = :email LIMIT 1";
						$s = $pdo->prepare($sql);
						$s->bindValue(':email', $value['Email']);
						$s->execute();
					}
					catch (PDOException $e){
						if(empty($error)){
							$error = array();
							$error[] = '<br>Error updating unsubscribe code for:';
						}
						$error[] = '<br>'.$value['Email'];
					}
				}else{
					$unsents[] = $value['Email'];
				}
			}
		}
		$pdo->commit();
		if(empty($unsents)){
			$_SESSION['messages'] = "Emails sent successfully.";
		}else{
			if(empty($error)){
				$error = array();
			}
			if(sizeof($count) == sizeof($unsents)){
				$error[] = "<br>Failed to send all emails.";
			}else{
				$error[] = "<br>Failed to send emails to:";
				foreach($unsents as $unsent){
					$error[] = "<br>$unsent";
				}
			}
		}
		if(!(!empty($unsents) && sizeof($count) == sizeof($unsents))){
			//Record Email
			try{
				$sql = "INSERT INTO `announcements` SET `sender_id` = '".$_SESSION['user']['id']."',`date` = '".date('Y-m-d h:i:s')."',`message` = :message";
				$s = $pdo->prepare($sql);
				$s->bindValue(':message', $_POST['subject'].'<br>'.$_POST['message']);
				$s->execute();
			}
			catch (PDOException $e){
				$error = 'Error uploading email to database.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			header("Location: /Admin");
			exit();
		}
		if(!empty($error)) {
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
	}else{
		$_SESSION['messages']='Some errors were found, please correct indicated fields.';
	}
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'email.html.php';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
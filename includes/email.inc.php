<?php
//Registration or Password Change verification email
function send_verify($to, $hash, $purpose, $subject, $HtmlMessage, $PlainMessage){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

	//set expiry date of verification code
	$time = strtotime(date('Y-m-d H:i:s') . ' + 1 day');

	//update user account with verification code
	try {
		$sql = 'UPDATE users SET `verify_code` = :hash, `verify_time` = :time, `verify_purpose` = :purpose WHERE `email` = :email LIMIT 1';
		$s = $pdo->prepare($sql);
		$s->bindValue(':hash', $hash);
		$s->bindValue(':time', $time);
		$s->bindValue(':purpose', $purpose);
		$s->bindValue(':email', $to);
		$s->execute();

		if(send_email($to,$subject,$HtmlMessage,$PlainMessage)) {
			return 1;
		}else{
			return 0;
		}
	} catch (PDOException $e) {
		$error = 'Error recording verification code. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
}

function send_email($to,$subject,$HtmlMessage,$PlainMessage){
	//Construct email
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->isHTML(true);
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465;
	$mail->Username = "aidan.inquires@gmail.com";
	$mail->Password = "bvXM5A8ti8u3OAG7WH3R";
	$mail->CharSet = 'ISO-8859-1';
	$mail->From = 'no-reply@'.$_SERVER['SERVER_NAME'];
	$mail->FromName = 'Aidan\'s Local';
	if(is_array($to)){
		foreach ($to as $value) {
			$mail->AddBCC($value);
		}
	} else {
		$mail->addAddress($to);
	}
	$mail->Subject = $subject;
	$mail->Body = $HtmlMessage;
	$mail->AltBody = $PlainMessage;
	//$mail->SMTPDebug = 1;

	//Development email blocker
	if(DEVELOPMENT) return true;

	//Send the email
	if($mail->send()) {
		return 1;
	} else {
		$error = 'Error sending emails to: <br>['.implode('], [', $to).']';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return 0;
	}
}

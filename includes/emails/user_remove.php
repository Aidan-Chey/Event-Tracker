<?php //Function to email user that their account has been removed
function userRemove($user_id,$transaction) {
	//retrieve removed user's email
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
	try{
		$s = $pdo->query("SELECT `email`
			FROM `users`
			WHERE `id` = $user_id
			LIMIT 1"
		);
	}
	catch (PDOException $e){
		$error = 'Error retrieving removed user\'s email.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$email = $s->fetch(PDO::FETCH_ASSOC)['email'];

	//create email
	$subject = 'Event Tracker | Account Removal';
	$link = 'http://'.$_SERVER['HTTP_HOST'].'/Audit/?Asked&id='.$transaction.'&ts&name&user_id#Results';
	$message1 = "Your Event Tracker account has been removed.";
	$message2 = "Removed on: ".date('Y-m-d H:i');
	$message3 = "If you do not agree with this removal, please contact an admin.";

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/emailHead.php';
	$htmlMessage = emailHead('html');
	$htmlMessage .= $message1;
	$htmlMessage .= "<br><br>".$message2;
	$htmlMessage .= "<br>".$message3;
	$htmlMessage .= "<br><br>Link (to reference for admin): <a href='$link'>$link</a>";
	$htmlMessage .= "<hr>
		<div style='text-align:center;'>
			Message automatically sent by <a href='http://".$_SERVER['HTTP_HOST']."'>Event Tracker</a>
		</div>
		<hr>";
	$htmlMessage .= "</body></html>";

	$plainMessage = emailHead('plain')."
".$message1."
\r\n
".$message2."
".$message3."

Link: $link
\r\n
Message automatically sent by Event Tracker at http://".$_SERVER['HTTP_HOST'];

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';
	send_email($email,$subject,$htmlMessage,$plainMessage);

	return true;
}
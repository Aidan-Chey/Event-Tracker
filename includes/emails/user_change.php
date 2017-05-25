<?php //Function to email user that their account has been changed
function userChange($email,$transaction) {
	$subject = 'Event Tracker | Account Change';
	$link = 'http://'.$_SERVER['HTTP_HOST'].'/Audit/?Asked&id='.$transaction.'&ts&name&user_id#Results';
	$message1 = "Your Event Tracker account has been changed.";
	$message2 = "Changed on: ".date('Y-m-d H:i');
	$message3 = "If you do not agree with these changes, please contact an admin.";

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

Link (to reference for admin): $link
\r\n
Message automatically sent by Event Tracker at http://".$_SERVER['HTTP_HOST'];

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';
	send_email($email,$subject,$htmlMessage,$plainMessage);

	return true;
}
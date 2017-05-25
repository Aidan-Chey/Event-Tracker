<?php //constructs and sends out a email to verify a users validity
function forgotEmail($email){
	$salt = randomString(10);

	//Verification code
	$hashEmail = md5($email.$salt);

	//Construct Email
	$subject = "Email Verification at ".$_SERVER['HTTP_HOST'];

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/emailHead.php';
	$htmlMessage = emailHead('html');
	$htmlMessage .= "<p>
			Recently an account under this email address on <b>".$_SERVER['HTTP_HOST']."</b> was requested to have it's password reset.
			<br>
			This email was sent to <b>verify ownership</b> of the email, if you do not have an account on ".$_SERVER['HTTP_HOST']." or did not authorize this, ignore this email.
		</p>
		<p>
			<b>Inorder to verify</b> your email address <a href='http://".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail/?code=".$hashEmail."'>use this link</a>.
			<br>
			Alternativly, use this verification code <b>".$hashEmail."</b> at http://".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail
		</p>";
	$htmlMessage .= "<hr>
		<div style='text-align:center;margin-top:15px;''>
			Message automatically sent by <a href='http://".$_SERVER['HTTP_HOST']."'>Event Tracker</a>
		</div>
		<hr>";
	$htmlMessage .= "</body></html>";

	$plainMessage = emailHead('plain');
	$plainMessage .= "Recently an account under this email address on ".$_SERVER['HTTP_HOST']." was requested to have it's password reset.
This email was sent to verify ownership of the email, if you do not have an account on http://".$_SERVER['HTTP_HOST']." or did not authorize this, ignore this email.

Inorder to verify your email address use this link:
http://".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail/?code=".$hashEmail."
Alternativly, use this verification code \"".$hashEmail."\" at http://".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail
\r\n
Message automatically sent by Event Tracker at http://".$_SERVER['HTTP_HOST'];

	if(send_verify($email, $hashEmail, "forgot", $subject, $htmlMessage,$plainMessage)) {
		return 1;
	} else {
		return 0;
	}
}
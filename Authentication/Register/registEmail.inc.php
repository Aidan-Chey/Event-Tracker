<?php //constructs and sends out a email to verify a users validity
function registEmail($email) {
	$salt = randomString(10);

	//Verification code
	$hashEmail = md5($email.$salt);

	//construct email
	$subject = "Email Verify for ".$_POST['email']." at ".$_SERVER['HTTP_HOST'];

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/emailHead.php';
	$htmlMessage = emailHead('html');
	$htmlMessage .= "<p>
			Recently an account under this email address was created on ".$_SERVER['HTTP_HOST'].".<br>
			This email was sent to verify the ownership of the email, if you did not create an account on ".$_SERVER['HTTP_HOST']." ignore this email.
		</p>
		<p>
			Inorder to verify your email address please <a href='".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail/?code=".$hashEmail."'>use this URL link</a> or copy and paste it into a url address bar: <br>".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail/?code=".$hashEmail."
		</p>
		<p>
			Alternativly, use this verification code \"".$hashEmail."\" at ".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail
		</p>";
	$htmlMessage .= "<hr>
		<div style='text-align:center;margin-top:15px;''>
			Message automatically sent by <a href='http://".$_SERVER['HTTP_HOST']."'>Event Tracker</a>
		</div>
		<hr>";
	$htmlMessage .= "</body></html>";

	$plainMessage = emailHead('plain');
	$plainMessage .= "Recently an account under this email address was created on ".$_SERVER['HTTP_HOST'].".
This email was sent to verify the ownership of the email, if you did not create an account on http://".$_SERVER['HTTP_HOST']." ignore this email.

Inorder to verify your email address please vists this address:
http://".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail/?code=".$hashEmail."
Alternativly, use this verification code \"".$hashEmail."\" at http://".$_SERVER['HTTP_HOST']."/Authentication/VerifyEmail
\r\n
Message automatically sent by Event Tracker at http://".$_SERVER['HTTP_HOST'];

	try {
		send_verify($email, $hashEmail, "register", $subject, $htmlMessage,$plainMessage);
		return 1;
	} catch (Exception $e) {
		return 0;
	}
}
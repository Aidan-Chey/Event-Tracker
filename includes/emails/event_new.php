<?php //Script runs when a new event is made; informing related users of the new event
function eventNew($eventID,$transaction){

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/details.inc.php';
	$eventDetails = eventDetails($eventID,'events');


	$recipients = array(
		$eventDetails['user_id']
	);

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/emails.inc.php';
	$emails = userEmails($recipients);

	$subject = 'Event Tracker | New Event';
	$search = 'http://'.$_SERVER['HTTP_HOST'].'/Search/?Asked&ID='.$eventID.'#Results';
	$link = 'http://'.$_SERVER['HTTP_HOST'].'/Audit/?Asked&id='.$transaction.'&ts&name&user_id#Results';
	$message = 'A new event has been created.';

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/emailHead.php';
	$htmlMessage = emailHead('html');
	$htmlMessage .= $message;
	$htmlMessage .= "<br><table>";

	$htmlContent = array(
		'Event ID: ' => $eventID
		,'Requester: ' => $eventDetails['requester']
		,'Description: ' => $eventDetails['description']
		,'Accountable: ' => $eventDetails['accountable']
		,'View Event: ' => "<a href='$search'>$search</a>"
		,'<br>' => '<br>'
		,'Audit transaction: ' => "<a href='$link'>$link</a>"
	);

	foreach ($htmlContent as $key => $value) {
		$htmlMessage .= "<tr><td style='font-family:Tahoma,sans-serif;'><b>$key</b></td><td style='font-family:Tahoma,sans-serif;'>$value</td></tr>";
	}

	$htmlMessage .= "</table>";
	$htmlMessage .= "<hr>
		<div style='text-align:center;'>
			Message automatically sent by <a href='http://".$_SERVER['HTTP_HOST']."'>Event Tracker</a>
		</div>
		<hr>";
	$htmlMessage .= "</body></html>";

	$plainMessage = emailHead('plain')."
".$message."
\r\n
Event ID: $eventID
Requester: ".$eventDetails['requester']."
Description: ".$eventDetails['description']."
Accountable: ".$eventDetails['accountable']."
View Event: $search

Audit Transaction: $link
\r\n
Message automatically sent by Event Tracker at http://".$_SERVER['HTTP_HOST'];

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';
	send_email($emails,$subject,$htmlMessage,$plainMessage);

	return true;
}
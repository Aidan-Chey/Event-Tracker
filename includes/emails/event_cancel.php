<?php //Script runs when an event is cancelled, informing associated users on the status
function eventCancel($who,$eventID,$transaction){
	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/details.inc.php';
	$eventDetails = eventDetails($eventID,'events');

	$emails = array(
		$eventDetails['requester_email']
	);

	$subject = 'Event Tracker | Event '.$eventID.' Cancelled';
	$search = 'http://'.$_SERVER['HTTP_HOST'].'/Search/?archive=on&Asked&ID='.$eventID.'#Results';
	$link = 'http://'.$_SERVER['HTTP_HOST'].'/Audit/?Asked&id='.$transaction.'&ts&name&user_id#Results';
	$message = "An Event related to you has been cancelled and is now archived.";

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/emailHead.php';
	$htmlMessage = emailHead('html');
	$htmlMessage .= $message;
	$htmlMessage .= "<br><table>";

	$htmlContent = array(
		'Event ID: ' => $eventID
		,'Requester: ' => $eventDetails['requester']
		,'Description: ' => $eventDetails['description']
		,'New Status: ' => 'Cancelled'
		,'View Event: ' => "<a href='$search'>$search</a>"
		,'<br>' => '<br>'
		,'By: ' => $who
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
New Status: Cancelled
View Event: $search

By: $who
Audit Transaction: $link
\r\n
Message automatically sent by Event Tracker at http://".$_SERVER['HTTP_HOST'];

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';
	send_email($emails,$subject,$htmlMessage,$plainMessage);

	return true;
}
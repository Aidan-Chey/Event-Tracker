<?php //Script runs when a event is edited, associated users on the request status
function eventEdit($who,$eventID,$transaction){
	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/details.inc.php';
	$eventDetails = eventDetails($eventID,'events');

	$emails = array(
		$eventDetails['requester_email']
	);

	$subject = 'Event Tracker | Event '.$eventID.' Edited';
	$search = 'http://'.$_SERVER['HTTP_HOST'].'/Search/?Asked&ID='.$eventID.'#Results';
	$link = 'http://'.$_SERVER['HTTP_HOST'].'/Audit/?Asked&id='.$transaction.'&ts&name&user_id#Results';
	$message = "An event related to you has been edited.";

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/emailHead.php';
	$htmlMessage = emailHead('html');
	$htmlMessage .= $message;
	$htmlMessage .= "<br><table>";

	$htmlContent = array(
		'Request ID: ' => $eventID
		,'Requester: ' => $eventDetails['requester']
		,'Description: ' => $eventDetails['description']
		,'Status: ' => $eventDetails['status']
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
Request ID: $eventID
Requester: ".$eventDetails['requester']."
Description: ".$eventDetails['description']."
Status: ".$eventDetails['status']."
View Event: $search

By: $who
Audit Transaction: $link
\r\n
Message automatically sent by Event Tracker at http://".$_SERVER['HTTP_HOST'];

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/email.inc.php';
	send_email($emails,$subject,$htmlMessage,$plainMessage);

	return true;
}
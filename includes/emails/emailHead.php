<?php //function to output the correct code for the type of email head needed (HTML or Plan text)
function emailHead($type) {
	switch ($type) {
		case 'html':
			return "<html>
<body style='font-family:Tahoma,sans-serif;padding:0;margin:0;background-color:#F4F4F4;'>
	<a href='http://".$_SERVER['HTTP_HOST']."' target='_blank'  style='display:block;text-decoration:none;'>
		<div style='background-color:#328AE2;'>
			<h1 style='color:#FBFBFB;text-align:center;font-size:1.8em;padding:15px;'>Event Tracker</h1>
		</div>
	</a>";

		case 'plain':
			return "Event Tracker - (This message is in plain text becuase your email system does not allow HTML emails)";
	}
}
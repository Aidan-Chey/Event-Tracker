<?php //Function to convert a stage value to it's status
function status($input,$variables) {
	//Determine status based off stage and extra values
	switch ($input) {
		case 'cancelled': return 'Cancelled';
		case 'decline': return'Declined';
		case 'apply': return 'With Operator';
		case 'confirm': return (
			!empty($variables['placeholder']) && ($variables['placeholder'] == 't' || $variables['placeholder'] == 'Yes')
				? 'Placeholder'
				: 'With Manager'
		);
		case 'approve': return 'Approved';
		default: return 'Unknown status; missing information';
	}
}
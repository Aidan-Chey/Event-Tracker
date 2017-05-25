<?php //Included code to handle the addition of user's comments
if(isset($_POST['addComment'])) {
	include $_SERVER['DOCUMENT_ROOT'].'/includes/comments/upload.inc.php';
	$commentId = commentUpload($_POST['event_id'],$_POST['user_id'],$_POST['content']);
	if($commentId == false) {
		$error = 'Error, your comment was not added; comment upload function returned false.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}else{
		$_SESSION['messages'] = "Comment added to event: ".$_POST['event_id'];
		unset($_POST['content']);
	}
}
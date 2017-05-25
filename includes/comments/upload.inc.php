<?php //Function to upload new comments to the comments table
function commentUpload($event,$user,$content) {
	if (!is_numeric($event)) {
		$error = "Error, event ID for comment upload is not numeric.";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	}
	if (!is_numeric($user)) {
		$error = "Error, user ID ($user) for comment upload is not numeric.";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	}
	if (empty($content)) {
		$errors['content'] = "Error, comment for upload is empty.";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	}elseif(strlen($content) > 500){
		$errors['content'] = "Comment too long (max 500 characters).";
	}
	if(!empty($error)){
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return false;
	}
	if(empty($errors)) {
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
		try {
			$s=$pdo->prepare("INSERT INTO `comments` SET `event_id`=:event,`user_id`=:user,`content`=:content");
			$s->execute(array(
				':event' => $event
				,':user' => $user
				,':content' => $content
			));
		} catch (PDOException $e) {
			$error = "Error occured while adding comment to event";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			return false;
		}
		return $pdo->lastInsertId();
	}else{
		return $errors;
	}
}
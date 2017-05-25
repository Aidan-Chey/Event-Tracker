<?php //script to delete a draft
if(isset($_POST['delete']) && !empty($_POST['listSelect']) && !empty($_SESSION['user']['id'])){
	try{
		$pdo->query('DELETE From `drafts` WHERE `user_id` = "'.$_SESSION['user']['id'].'" AND `id` = "'.$_POST['listSelect'].'" LIMIT 1');
	}catch(PDOException $e){
		$error = ' Error deleting draft event';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	//Success Message
	$_SESSION['messages'] = " Draft deleted.";
}
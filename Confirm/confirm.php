<?php
if(isset($_POST['confirm']) || isset($_POST['decline'])){
	//test user's roll & if logged it
	if(userHasRole(array('operator','admin'))) {
		//Check user ID
		include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/approvals/user.php';

		//Validate Feedback
		include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/approvals/feedback.php';

		//If validation is successful
		if(empty($errors)){
			$set_array = array(
				'confirmer_id' => $_SESSION['user']['id']
				,'confirmer_checked' => strtotime('now')
				,'last_change' => strtotime('now')
			);
			$where = array(
				"`id` = ".$_POST['event_id']
				,"`status` = 'apply'"
			);
			$placeholders = array();

			//add feedback if not empty
			if(!empty($_POST['feedback'])){
				$set_array['confirmer_feedback'] = $_POST['feedback'];
			}

			//decision based on confirm or decline
			if(isset($_POST['confirm'])){$set_array['status'] = 'confirm';}
			elseif(isset($_POST['decline'])){$set_array['status'] = 'decline';}
			else{
				$error = 'Error: event was neither confirmed or declined';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}

			//organise set and where arrays
			foreach ($set_array as $key => $value) {
				$set[] = "`$key` = :$key";
				$placeholders[":$key"] = $value;
			}

			$set = implode(',',$set);
			$where = implode(' AND ',$where);

			$pdo->beginTransaction();

			//update confirmation data in event
			$s = $pdo->prepare("UPDATE `events` SET $set WHERE $where");
			try{
				$s->execute($placeholders);
			}
			catch(PDOException $e){
				$error = 'Error submiting confirmed event. ';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}

			$status = (isset($_POST['confirm']) ? 'Confirmed' : 'Declined' );

			include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/audit.inc.php';
			$transaction_id = audit($_SESSION['user']['id'],'event',$_POST['event_id'],"Event $status",$set_array);
			if(empty($transaction_id)) {
				$pdo->rollback();
				$error = 'Error creating audit entry for confirmed event.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}

			include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/event_update.php';
			if(!eventUpdate($status,$_POST['feedback'],$_SESSION['user']['id'].' - '.$_SESSION['user']['name'],$_POST['event_id'],$transaction_id)) {
				$pdo->rollback();
				$error = 'Error sending event update emails.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}

			$pdo->commit();

			//success message based on button pressed
			if(isset($_POST['confirm'])){
				$_SESSION['messages'] = " Event Confirmed.";
			}
			elseif(isset($_POST['decline'])){
				$_SESSION['messages'] = " Event Declined.";
			}

			//Select next avaliable event for confirmation
			try{
				$s = $pdo->query("SELECT `id` FROM `events` WHERE `status` = 'apply' ORDER BY `start` ASC LIMIT 1");
			}
			catch(PDOException $e){
				$error = 'Error retrieving next event for confirmation.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			if($s->rowCount() > 0){
				header("Location: /Confirm/?listSelect=".$s->fetchAll()[0][0]."#");
			}else{
				header("Location: /");
			}
			exit();
		}
	}else{
		header("Location: /");
		exit();
	}
}
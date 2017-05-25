<?php

if(isset($_POST['approve']) || isset($_POST['decline'])){
	//test user's roll & if logged it
	if(userHasRole(array('manager','admin'))) {
		//Check user ID
		include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/approvals/user.php';

		//Validate Feedback
		include $_SERVER['DOCUMENT_ROOT'].'/includes/validation/approvals/feedback.php';

		//If validation is successful
		if(empty($errors)){
			$set_array=array(
				'approver_id' => $_SESSION['user']['id']
				,'approver_checked' => strtotime('now')
				,'last_change' => strtotime('now')
			);
			$where=array(
				'`id` = "'.$_POST['event_id'].'"'
				,'`status` = "confirm"'
			);
			$placeholders = array();

			//add feedback if not empty
			if(!empty($_POST['feedback'])){
				$set_array['approver_feedback'] = $_POST['feedback'];
			}

			//decision based on confirm or decline
			if(isset($_POST['approve'])){$set_array['status'] ='approve';}
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

			//upload confirmation
			$pdo->beginTransaction();
			try{
				$s = $pdo->prepare("UPDATE `events` SET $set WHERE $where LIMIT 1");
				$s->execute($placeholders);
			}
			catch(PDOException $e){
				$error = 'Error submting approved event. ';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}

			$status = (isset($_POST['approve']) ? 'Approved' : 'Declined' );

			include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/audit.inc.php';
			$transaction_id = audit($_SESSION['user']['id'],'event',$_POST['event_id'],"Event $status",$set_array);
			if(empty($transaction_id)) {
				$pdo->rollback();
				$error = 'Error creating audit entry for approved event.';
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
			if(isset($_POST['approve'])){
				$_SESSION['messages'] = " Event Approved.";
			}
			elseif(isset($_POST['decline'])){
				$_SESSION['messages'] = " Event Declined.";
			}

			//Select next avaliable event for confirmation
			try{
				$s = $pdo->query('SELECT `id` FROM `events` WHERE `status` = "confirm" ORDER BY `start` ASC LIMIT 1');
			}
			catch(PDOException $e){
				$error = 'Error retrieving next event for approval. ';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			if($s->rowCount() > 0){
				header("Location: /Approve/?listSelect=".$s->fetchAll(PDO::FETCH_ASSOC)[0]."#");
			}else{
				header("Location: /#");
			}
			exit();
		}
	}else{
		header("Location: /");
		exit();
	}
}
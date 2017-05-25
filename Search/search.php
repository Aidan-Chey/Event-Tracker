<?php
if(isset($_GET['Asked'])){
	//Validate requester
	if(!empty($_GET['requester']) && !strlen($_GET['requester']) > 25) {
		$errors['requester'] = ' Requester name too long (max 25 characters).';
	}
	//Validate date
	if(!empty($_GET['date'])){
		if(!strpos($_GET['date'], '-')){
			$errors['date'] = ' Please enter a date seperated by a dash; Year-Month.';}
		else{
			list($year, $month) = explode('-', $_GET['date']);
			if(!checkdate($month,'1',$year)){
				$errors['date'] = ' Please enter a valid date.';
			}
		}
	}
	//Validate id
	if(!empty($_GET['id']) && !is_numeric($_GET['id'])) {
		$errors['id'] = ' Please use a numeric ID.';
	}

	if(empty($errors)){
		$where = array('true');
		$placeholders = array();
		if(isset($_GET['archives'])){
			$table = 'archives';
		}else{
			$table = 'events';
		}

		// An requester is selected
		if (!empty($_GET['requester'])){
			$where[] = "`requester` LIKE :requester";
			$placeholders[':requester'] = "%".$_GET['requester']."%";
		}
		// A date is selected
		if (!empty($_GET['date'])){
			$where[] = "!(`start` > :lastdate) AND !(`end` < :firstdate)";
			$placeholders[':firstdate'] = date('Y-m-d',strtotime($_GET['date']));
			$placeholders[':lastdate'] = date('Y-m-t',strtotime($_GET['date']));
		}
		// A date is selected
		if (!empty($_GET['id'])){
			$where[] = "`id` LIKE :id";
			$placeholders[':id'] = "%".$_GET['id']."%";
		}

		$where = implode(' AND ', $where);

		try{
			$s = $pdo->prepare(
				"SELECT $mysql_event_list FROM `$table` WHERE $where ORDER BY `start` ASC"
			);
			$s->execute($placeholders);
		}
		catch (PDOException $e){
			$error = 'Error retrieving events for search list. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		$events = $s->fetchAll(PDO::FETCH_ASSOC);
	}
}
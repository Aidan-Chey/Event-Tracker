<?php 	//Script to query events and archive tables for event to build report on
if(!empty($_GET['start']) AND !empty($_GET['end'])){

	if(!strtotime($_GET['start'])) $errors['start'] = 'Unrecognisable start date format';
	if(!strtotime($_GET['end'])) $errors['end'] = 'Unrecognisable end date format';

	if(empty($errors['start']) && empty($errors['end'])) {
		$from = array('events','archives');
		$where = "`start` <= '".strtotime($_GET['end'].' + 1 day')."' AND `end` >= '".strtotime($_GET['start'])."'";

		//Connect to Database
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

		$summary = array();

		foreach ($from as $num => $table) {
			try {
				$s = $pdo->prepare("SELECT $mysql_event_list FROM `$table` WHERE $where ORDER BY `end` ASC");
				$s->execute();
			} catch (PDOException $e) {
				$error = 'Error retrieving summary report events from '.$table.' table.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			if($s->rowCount() > 0) {
				foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $event) {
					$event['table'] = $table;
					$summary[] = $event;
				}
			}
		}
	}
}
<?php //Script to retireve the information for the approval length report
function approveDuration($end,$begin) {
	$begin = new DateTime($begin);
	$end = new DateTime($end);
	$duration= $begin->diff($end)->format('%d days, %h hours, %i minutes');
	return $duration;
}
function colate($averages,$first,$last,$stage,$id) {
	$duration = strtotime($last) - strtotime($first);
	$averages[$stage]['data'][$id] = array('duration'=>$duration,'date'=>$last);
	$averages[$stage]['total'] += $duration;
	$averages[$stage]['IDs'][] = $id;
	$averages[$stage]['count'] ++;
	return $averages;
}
if(!empty($_GET['begin']) && !empty($_GET['end'])){

	//date format validation
	if(!strtotime($_GET['begin'])) $errors['begin'] = 'Unrecognisable start date format';
	if(!strtotime($_GET['end'])) $errors['end'] = 'Unrecognisable start date format';

	if(empty($errors['begin']) && empty($errors['end'])) {
		$select = "
			$mysql_event_list
			,FROM_UNIXTIME(`created`,'".mysql_dateTime."') AS 'created'
			,FROM_UNIXTIME(`confirmer_checked`,'".mysql_dateTime."') AS 'confirmer_checked'
			,FROM_UNIXTIME(`approver_checked`,'".mysql_dateTime."') AS 'approver_checked'
		";

		//Retrieve needed event information
		try {
			$s = $pdo->prepare(
				"SELECT $select
				FROM `events`
				WHERE `status` NOT IN ('apply','decline')
				AND `placeholder`!= 1
				AND `created` <= :end
				AND `end` >= :start
				");
			$s->execute(array(':start'=>strtotime($_GET['begin']),':end'=>strtotime($_GET['end'].' + 1 day')));
		} catch (PDOException $e) {
			$error = 'Error retrieving event timing information for Approval Length report.'.$e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		if($s->rowCount() > 0) {
			//Collect information for sumations
			$lengths = array();
			$averages = array(
				'confirmer'=>array('data'=>array(),'total'=>0,'count'=>0)
				,'approver'=>array('data'=>array(),'total'=>0,'count'=>0)
			);

			foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $event) {
				$base = $event['created'];
				if(!empty($event['edited']) && $event['edited'] > 0) {
					$averages = colate($averages,$base,$event['edited'],'edited',$event['id']);
					$base=$event['edited'];
				}
				foreach (array('confirmer','approver') as $name) {
					if(!empty($event[$name.'_checked']) && strtotime($base) < strtotime($event[$name.'_checked'])) {
						$averages = colate($averages,$base,$event[$name.'_checked'],$name,$event['id']);
						$base = $event[$name.'_checked'];
					}
				}
				unset($base,$date);
			}
			foreach ($averages as $stage => $data) {
				if($data['count'] > 0)
				$averages[$stage]['averageDays'] = ceil( ($data['total'] / $data['count']) / 86400 );
			}
		}
	}
}

if(!empty($_POST['selection']) && !empty($_POST['IDs'])) {
	$links[] = 'table';
	//Decide on the fields to query based on the selection
	switch ($_POST['selection']) {
		case 'confirmer': $name = "(SELECT `name` FROM `users` WHERE `id` = `events`.`confirmer_id` LIMIT 1) as 'confirmer'"; break;
		case 'approver': $name = "(SELECT `name` FROM `users` WHERE `id` = `events`.`approver_id` LIMIT 1) as 'approver'"; break;
	}

	$select =
		"`id`
		,`type`
		,`status`
		,(SELECT `name` FROM `users` WHERE `id` = `user_id` LIMIT 1) as 'requester'
		,`location`
		,FROM_UNIXTIME(`start`,'".mysql_date."') AS 'start'
		,FROM_UNIXTIME(`end`,'".mysql_date."') AS 'end'
		,$name
	";

	//Retrieve more event infomation for specific report
	try {
		$s=$pdo->prepare(
			"SELECT $select
			FROM `events`
			WHERE `id` IN ('".implode("','",$_POST['IDs'])."')");
		$s->execute();
	} catch (PDOException $e) {
		$error = 'Error retrieving detailed event information for Approval Length report. '.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}

	$lengthEvents = array();
	foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $num => $event) {
		$event['when'] = date('j M Y',strtotime($averages[$_POST['selection']]['data'][$event['id']]['date']));
		$event['days'] = ceil(($averages[$_POST['selection']]['data'][$event['id']]['duration']) / 86400);

		$lengthEvents[$num] = $event;

		switch ($_POST['selection']) {
			case 'edited': $lengthEvents[$num]['Who'] = $event['editor_id']; break;
			case 'reviewer': $lengthEvents[$num]['Who'] = $event['reviewer_name']; break;
			case 'trader': $lengthEvents[$num]['Who'] = $event['trader_name']; break;
			case 'manager': $lengthEvents[$num]['Who'] = $event['manager_name']; break;
			case 'gm': $lengthEvents[$num]['Who'] = $event['gm_name']; break;
			case 'ready': $lengthEvents[$num]['Who'] = $event['ready_name']; break;
		}
	}

	usort($lengthEvents, function($a, $b) {
		return $b['days'] - $a['days'];
	});
}
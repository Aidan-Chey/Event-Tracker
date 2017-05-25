<?php //Function to upload an entry into the Audit database table
function auditUpload($user,$item,$item_id,$action,$data) {
	$placeholders=array();
	$data += array(
		'user_id' => $user
		,'ts' => strtotime('now')
		,'item' => $item
		,'item_id' => $item_id
		,'action' => $action
	);

	foreach ($data as $column => $cell) {
		$set[] = "`$column`=:$column";
		$placeholders[":$column"] = $cell;
	}

	$set = implode(',',$set);
	include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
	try {
		$s=$pdo->prepare(
			"INSERT INTO `audits`
			SET $set
			");
		$s->execute($placeholders);
	} catch (PDOException $e) {
		$error = 'Error uploading audit entry. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		return false;
	}
	return $pdo->lastInsertId();
}
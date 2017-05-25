<?php //Function to combine auditing functions into easy to use script
function audit($user,$item,$item_id,$action,$new) {
	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/original.inc.php';
	$original = getOriginal($item_id,$item);

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/compare.inc.php';
	$output = auditCompare($new,$original);

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/compact.inc.php';
	if(!empty($output['original'])){
		$output['original'] = auditCompact($output['original']);
	}
	if(!empty($output['changed'])){
		$output['changed'] = auditCompact($output['changed']);
	}

	include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/upload.inc.php';
	$commentId = auditUpload($user,$item,$item_id,$action,$output);
	if(!empty($commentId)) {
		return $commentId;
	}
	return false;
}
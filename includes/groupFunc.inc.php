<?php
//Unit Group and Station reference array & functions
$Group['HLY'] = array(
	'Huntly' =>	array('HLY', 'HLY1', 'HLY2', 'HLY3', 'HLY4', 'HLY5', 'HLY6', 'HLY Common')
	);
$Group['TRO'] = array(
	'Tokaanu' => array('TKU', 'TKU1', 'TKU2', 'TKU3', 'TKU4', 'TKU Other'),
	'Rangipo' => array('RPO', 'RPO5', 'RPO6', 'RPO Other')
	);
$Group['WKA'] = array(
	'Tuai' => array('TUI', 'TUI1', 'TUI2', 'TUI3', 'TUI Other'),
	'Piripaua' => array('PRI', 'PRI4', 'PRI5', 'PRI Other'),
	'Kaitawa' => array('KTW', 'KTW6', 'KTW7', 'KTW Other')
	);
$Group['TEK'] = array(
	'Tekapo' => array('TEK', 'TEK1', 'TEK2', 'TEK3', 'TEK Other')
	);

function arraySearch1($grp, $array){
	foreach($array as $key => $value) {
		if($key == $grp){
			return true;
		}
	}
	return null;
}
function arraySearch2($stn, $grp, $array){
	foreach ($array["$grp"] as $key => $value) {
		if($key == $stn){
			return true;
		}
	}
	return null;
}
function arraySearch3($unt, $grp, $stn, $array){
	foreach ($array["$grp"]["$stn"] as $key => $value) {
		if($value == $unt){
			return true;
		}
	}
	return null;
}
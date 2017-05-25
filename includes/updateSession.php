<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/users.inc.php';
if(empty($_SESSION['user']['email'])){$email = null;}
else{$email = $_SESSION['user']['email'];}
foreach(getUsers(array('id','name','role'),array('email'=>array('='=>$email)),1) as $key => $value){
	$_SESSION['user']["$key"] = $value;
}
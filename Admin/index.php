<?php
$pageTitle = 'Admin';
$links = array('home');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

//Update user details
if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
}

if (!userHasRole('admin')){
	header('Location: /?Permissions');
}

if(isset($_GET['Archive'])){
	include 'archive.php';
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'admin_home.html';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
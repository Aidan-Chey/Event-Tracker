<?php
$pageTitle = 'Users';
$links = array('table');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

//Update user details
if(empty($_SESSION['user']['id']) || empty($_SESSION['user']['name']) || empty($_SESSION['user']['role'])){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/updateSession.php';
}

if (!userHasRole('admin')){
	header('Location: /?Permission');
}

include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

$masterAdmins = array('webmaster@eventtracker.aidancheyd.info', 'admin@eventtracker.aidancheyd.info','aidan.inquires@gmail.com');

//Retrive user list
try{
	$s = $pdo->query(
		"SELECT $mysql_users_list
		FROM `users`
		Order By `joined` DESC
	");
} catch (PDOException $e) {
	$error = 'Error fetching users from the database for users list';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}

if($s->rowCount() >0){
	$users = $s->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_GET['edit']) && isset($_GET['listSelect'])){
//Retrieve role list
	try {
		$s = $pdo->prepare('SELECT `id` FROM `roles`');
		$s->execute();
	}
	catch (PDOException $e) {
		$error = 'Error fetching roles from the database for user edit.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	$roles = $s->fetchAll(PDO::FETCH_COLUMN);

	foreach ($users as $findUser) {
		if(isset($_GET['listSelect']) && $findUser['id'] == $_GET['listSelect']){
			$editUser = array('id' => $findUser['id'], 'name' => $findUser['name'], 'email' => $findUser['email'], 'role' => $findUser['role'], 'sub' => $findUser['subscribed']);
		}
	}
	$edit = true;
}

if(isset($_POST['delete']) || isset($_POST['edit'])){
	include 'users.php';
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'users.html.php';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';
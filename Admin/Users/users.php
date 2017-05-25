<?php

//Editing
if(isset($_POST['edit'])){
	$errors = array();
	//Validate Email
	if(empty($_POST['email'])){
		$errors['email'] .= " Please enter a email.";
	}
	elseif(strlen($_POST['email']) > 100){
		$errors['email'] .= " Please enter a shorter email (max 100 characters).";
	}
	elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$errors['email'] .= " Please enter a valid email.";
	}
	elseif($_POST['email'] != $editUser['email']){
		foreach ($users as $user) {
			if($user['email'] == $_POST['email']){
				$errors['email'] .= " Email already taken.";
			}
		}
	}

	//Validate Name
	if(empty($_POST['name'])){
		$errors['name'] .= " Please enter a display name.";
	}
	elseif(strlen($_POST['name']) > 25){
		$errors['name'] .= " Please enter a shorter name (max 25 characters).";
	}
	elseif($_POST['name'] != $editUser['name']){
		foreach($users as $user){
			if($_POST['name'] == $user['name'] && $_POST['name'] != '[Removed]'){
				$errors['name'] .= " Name already taken.";
			}
		}
	}

	//Validate Role
	if(!empty($_POST['role']) && !in_array($_POST['role'], $roles)){
		$errors['role'] .= " Please use a role in the dropdown list.";
	}

	//Validate Subscribed
	if(empty($_POST['sub'])){
		$subscribed = 0;
	}
	elseif($_POST['sub'] == 'on'){
		$subscribed = 1;
	}
	else{
		$errors['sub'] = ' Please use the checkbox.';
	}

	//Check if there has been a change
	if($_POST['email'] == $editUser['email'] && $_POST['name'] == $editUser['name'] && $_POST['role'] == $editUser['role'] && $subscribed == $editUser['sub']){
		$errors['edit'] = " Nothing was changed.";
	}

	//Admin Saftey Checks
	if(strtolower($editUser['role']) == "admin" && !in_array($_SESSION['user']['email'], $masterAdmins)){
		@$errors['general'] .= " You can't edit admins.";
	}

	//If no errors
	if(empty($errors)){
		$placeholders = array();
		$where=array(
			'`id` = "'.$_POST['id'].'"'
		);

		$set_array = array(
			'email' => $_POST['email']
			,'role' => $_POST['role']
			,'name' => $_POST['name']
			,'subscribed' => ( !empty($_POST['sub']) ? 1 : 0)
		);

		//Organises user information for SQL query
		foreach ($set_array as $key => $value) {
			$set[] = " `$key` = :$key";
			$placeholders[":$key"] = $value;
		}

		$set = implode(',',$set);
		$where = implode(' AND ',$where);

		//Update Information in DB
		$pdo->beginTransaction();

		try{
			$s = $pdo->prepare("UPDATE `users`
				SET $set
				WHERE $where");
			$s->execute($placeholders);
		}
		catch (PDOException $e){
			$error = 'Error editing user.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/audit.inc.php';
		print_r($_POST);
		print_r($_SESSION);
		$transaction_id = audit($_SESSION['user']['id'],'user',$_POST['id'],'User Edit',array());
		if(empty($transaction_id)) {
			$pdo->rollback();
			$error = 'Error creating audit entry for user edit.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/user_remove.php';
		if(!userRemove($_POST['id'],$transaction_id)) {
			$pdo->rollback();
			$error = 'Error sending email for user edit.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		$pdo->commit();

		$_SESSION['messages'] = " User Edited.";
		header('Location: /Admin/Users');
		exit();
	}
}

//Deleteing
elseif(isset($_POST['delete'])){

	//Saftey Checks
	if(!in_array($_SESSION['user']['email'], $masterAdmins)){
		foreach($users as $user) {
			if($_POST['listSelect'] == $user['id'] && $user['email'] == $masterAdmins){
				$errors['general'] .= " Not allowed to edit this user.";
			}
			elseif($_POST['listSelect'] == $user['id'] && $user['role'] == "Admin"){
				$errors['general'] .= " You can't edit admins.";
			}

		}
	}

	if(empty($errors)){
		//Remove User from DB
		$pdo->beginTransaction();

		try{
			$pdo->query('UPDATE `users` SET `name` = "[Removed]", `password` = "removed", `role` = "Removed" WHERE `id` = '.$_POST['listSelect']);
		}
		catch (PDOException $e){
			$error = 'Error deleting user.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		include_once $_SERVER['DOCUMENT_ROOT'].'/includes/auditing/audit.inc.php';
		$transaction_id = audit($_SESSION['user']['id'],'user',$_POST['listSelect'],'User Removal',array());
		if(empty($transaction_id)) {
			$pdo->rollback();
			$error = 'Error creating audit entry for user removal.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		include_once $_SERVER['DOCUMENT_ROOT'].'/includes/emails/user_remove.php';
		if(!userRemove($_POST['listSelect'],$transaction_id)) {
			$pdo->rollback();
			$error = 'Error sending email for user removal.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}

		$pdo->commit();

		$_SESSION['messages'] = " User Deleted.";
		header('Location: /Admin/Users');
		exit();
	}
}
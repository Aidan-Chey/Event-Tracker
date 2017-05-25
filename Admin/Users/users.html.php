<h2>Users</h2>
<section>
	<p>Emails truncated, open edit panel to view full email address.</p>
	<form id="users">
		<?php $table = createTableData($users);
		include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>
		<p>
			<button formmethod="get" formaction="#edit" name="edit">Edit</button>
			<label class="button pointer" for="delete_user">Delete</label>
			<input id="delete_user" type="checkbox" class="hide" checked>
			<button formmethod="post" name="delete">Confirm Delete</button>
			<?php if(!empty($_SESSION['messages'])): ?>
				<br><span class="error"><?php htmlout($_SESSION['messages']); ?></span>
			<?php endif; ?>
			<?php if(!empty($errors['general'])): ?>
				<br><span class="error"><?php echo $errors['general']; ?></span>
			<?php endif; ?>
		</p>
	</form>
</section>
<?php if(isset($edit)): ?>
<a class="anchor" name="edit"></a>
<section id="edit">
	<h3>Edit User</h3>
	<form  method="post">
		<p>
			<label for="email">Email: <br>
			<input id="email" type="email" name="email" value="<?php if(!empty($_POST['email'])){ htmlout($_POST['email']); }else{ htmlout($editUser['email']); }?>">
			<?php if(!empty($errors['email'])): ?>
				<br><span class="error"><?php htmlout($errors['email']); ?></span>
			<?php endif; ?>
			</label>
		</p>
		<p>
			<label for="display">Display Name: <br>
			<input id="display" name="name" value="<?php if(!empty($_POST['name'])){ htmlout($_POST['name']); }else{ htmlout($editUser['name']); }?>">
			<?php if(!empty($errors['name'])): ?>
				<br><span class="error"><?php htmlout($errors['name']); ?></span>
			<?php endif; ?>
			</label>
		</p>
		<p>
			<label for="role">Role: <br>
			<select id="role" name="role">
				<option selected></option>
				<?php foreach ($roles as $role): ?>
					<option <?php if((isset($_POST['role']) && $_POST['role'] == $role) || (isset($editUser['role']) && strtolower($role) == strtolower($editUser['role']))){echo 'selected';} ?>><?php echo $role; ?></option>
				<?php endforeach ?>
			</select>
			<?php if(!empty($errors['role'])): ?>
				<br><span class="error"><?php echo $errors['role']; ?></span>
			<?php endif; ?>
			</label>
		</p>
		<p>
			<label for="sub">Subscribed: <br></label>
			<input id="sub" name="sub" type="checkbox" <?php if(!empty($_POST['sub']) && $_POST['sub'] == true){ echo 'checked'; }elseif(strtolower($editUser['sub']) == 'yes'){ echo "checked"; }?>>
		</p>
		<p>
			<input type="hidden" name="id" value="<?php echo $_GET['listSelect']; ?>">
			<input type="submit" name="edit">
			<a class="button" href="/Admin/Users">Cancel Edit</a>
			<?php if(!empty($errors['edit'])): ?>
				<br><span class="error"><?php echo $errors['edit']; ?></span>
			<?php endif; ?>
		</p>
	</form>
</section>
<?php endif; ?>


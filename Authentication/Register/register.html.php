<p>
	This form will add you as User so you can use this application.
</p>
<section class="basic_form">
	<form  method="post">
		<h3>Registeration</h3>
		<p>
			<label for="name">Display Name: </label>
			<input name="name" id="name" maxlength="50" autofocus onkeyup="nameValid(this)" value="<?php if(!empty($_POST['name'])) htmlout($_POST['name']); ?>" required>
			<?php if(!empty($errors['name'])): ?>
				<span class="error"><?php echo $errors['name']; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="email">Email Address: </label>
			<input type="email" name="email" id="email" maxlength="100" onkeyup="emailValid(this)" value="<?php if(!empty($_POST['email'])) htmlout($_POST['email']); ?>" required>
			<?php if(!empty($errors['email'])): ?>
				<span class="error"><?php echo $errors['email']; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="password">Password: </label>
			<input type="password" name="password" id="password" maxlength="120" required onblur="confirmpass()">
			<label for="password2">Confirm Password: </label>
			<input type="password" name="password2" id="password2" maxlength="120" required onkeyup="confirmpass(this)">
			<?php if(!empty($errors['password'])): ?>
				<span class="error"><?php echo $errors['password']; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<button name="register">Register</button>
			<a class="button" href="/Authentication/Login/">Cancel</a>
			<?php if(!empty($_SESSION['messages'])){echo "<span class='error'>".$_SESSION['messages']."</span>";} ?>
		</p>
	</form>
</section>
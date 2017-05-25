<p>
	Inorder to use this tool you are required to use an account with sufficient permissions.
</p>
<?php if(userLoggedIn()): ?>
	<section class="basic_form">You are already logged in!</section>
<?php else: ?>
	<section class="basic_form">
		<form method="post">
			<p>
				<label for="email">Email: </label>
				<input autofocus type="email" name="email" id="email" maxlength="100" value="<?php if(!empty($_POST["email"])) htmlout($_POST["email"]); ?>" required>
				<?php if(!empty($errors['email'])) echo "<span class='error'>".$errors['email']."</span>"; ?>
			</p>
			<p>
				<label for="password">Password: </label>
				<input type="password" name="password" id="password" maxlength="120" required>
				<?php if(!empty($errors['password'])) echo "<span class='error'>".$errors['password']."</span>"; ?>
			</p>
			<p>
				<?php if (!empty($errors['general'])) echo "<span class='error'>".$errors['general']."</span>"; ?>
				<input type="hidden" name="login">
				<button>Login</button>
				<a class="button" href="/Authentication/Forgot/">Forgot Password</a>
				<?php if(!empty($_SESSION['messages'])){echo "<span class='error'>".$_SESSION['messages']."</span>";} ?>
				<?php if(!empty($_COOKIE['logCount'])){echo "<span>Attempts Remaining: " . (5 - $_COOKIE['logCount']) . "</span>";} ?>
			</p>
		</form>
	</section>

	<section class="basic_form">
		<b>Don't have an account?</b>
		<a class="button" href="/Authentication/Register/">Register</a>
	</section>
<?php endif; ?>
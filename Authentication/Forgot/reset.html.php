<section class="basic_form">
	<h3>Password Reset</h3>
	<form method="post">
		<p>
			<label for="password">New Password: </label>
			<input type="password" name="password" id="password" maxlength="100" required onblur="confirmpass()">

			<label for="password2">Confirm Password: </label>
			<input type="password" name="password" id="password2" maxlength="100" required onkeypress="confirmpass(this)">
			<?php if(!empty($errors['password'])): ?><span class='error'><?php htmlout($errors['password']); ?></span><?php endif; ?>
		</p>
		<p>
			<button name="reset">Reset Password</button>
			<a class="button" href="/Authentication/Login/">Back to Login</a>
			<?php if(!empty($errors['general'])){echo "<span class='error'>".$errors['general']."</span>";} ?>
			<?php if(!empty($_SESSION['messages'])){echo "<span class='error'>".$_SESSION['messages']."</span>";} ?>
		</p>
	</form>
</section>
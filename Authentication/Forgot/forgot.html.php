<section class="basic_form">
	<h3>Forgot Password</h3>
	<form method="post">
		<p>
			<label for="email">Email: </label>
			<input autofocus type="email" name="email" id="email" maxlength="100" value="<?php if(!empty($_POST["email"])) htmlout($_POST["email"]); ?>" required>
			<?php if(!empty($errors['email'])): ?><span class='error'><?php htmlout($errors['email']); ?></span><?php endif; ?>
		</p>
		<p>
			<button name="forgot">Submit</button>
			<a class="button" href="/Authentication/Login/">Cancel</a>
			<?php if(!empty($_SESSION['messages'])){echo "<span class='error'>".$_SESSION['messages']."</span>";} ?>
		</p>
	</form>
</section>
<section class="basic_form">
	<?php if(!empty($_SESSION['messages'])): ?>
	<div class="error"><?php echo $_SESSION['messages']; ?></div>
	<?php endif; ?>
	<p>Emails subscribers. Primarly intended for use on major site updates.<b>Do not miss use.</b></p>
	<form action="" method="post">
		<p>
			<label>Subject:</label>
			<input type="text" name="subject" minlength="5" maxlength="100" value="<?php if(!empty($_POST['subject'])){ htmlout($_POST['subject']); }?>">
			<?php if(!empty($errors['subject'])){echo "<span class='error'>".$errors['subject']."</span>";} ?>
		</p>
		<p>
			<label>Message: (HTML enabled)</label>
			<textarea name="message" minlength="20" maxlength="3000"><?php if(!empty($_POST['message'])){ htmlout($_POST['message']); }?></textarea>
			<?php if(!empty($errors['message'])){echo "<span class='error'>".$errors['message']."</span>";} ?>
		</p>
		<p>
			<button name="email">Submit</button>
		</p>
	</form>
</section>
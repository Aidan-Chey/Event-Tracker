<h3>Email Verification</h3>
<section class="basic_form">
	<form method="get">
		<p>Please enter your verification code from the email.</p>
		<p>
			<label for="field_code">Code: </label>
			<br>
			<input id="field_code" name="code" autofocus required>
		</p>
		<p>
			<button>Submit</button>
			<a class="button" href="/Authentication/Login/">Cancel</a>
			<?php if(!empty($_SESSION['messages'])){echo "<br><span class='error'>".$_SESSION['messages']."</span>";} ?>
		</p>
	</form>
	<?php if(!empty($_GET['user']['email'])): ?>
	<form>
		<div>Send the varification code agian.</div>
		<button name="resend">Re-Send</button>
	</form>
<?php endif; ?>
</section>
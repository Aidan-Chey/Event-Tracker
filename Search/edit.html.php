<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/hotkeys.inc.html'; ?>
<form id="Form_Top" method="post">
	<section id='event'>
		<?php $form='edit'; ?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/event.inc.php'; ?>
		<h4 class="center">Changed events will no longer have been confirmed or approved</h4>
		<input type="hidden" name="edit">
		<input type="hidden" name="listSelect" value="<?php echo $details['id']; ?>">
		<p>
			<button id='submit' name="submit">Submit</button>
		</p>
	</section>
</form>
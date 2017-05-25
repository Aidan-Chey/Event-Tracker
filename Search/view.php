<?php if(!empty($details['type'])){ $type = $details['type'] ;} ?>
<?php $form='view' ?>
<a id="Form_Top"></a>
<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/stages.inc.html'; ?>
<section id='event'>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/event.inc.php'; ?>
	<?php if(!userHasRole('')): ?>
	<form class="noPrint center" method="post" action="">
		<?php if(userHasRole('admin') || $details['user_id'] == $_SESSION['user']['id']): ?>
			<label class="button" for="delete_event">Cancel Request</label>
			<input id="delete_event" type="checkbox" class="hide" checked>
			<button name="cancel" value="<?php echo $details['id']; ?>">Confirm Cancel</button>
		<?php endif; ?>
	</form>
	<?php endif; ?>
</section>
<?php if(!empty($details['confirmer_checked'])): ?>
<section id="confirm">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/confirm.inc.php'; ?>
</section>
<?php endif; if(!empty($details['approver_checked'])): ?>
<section id="confirm">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/approve.inc.php'; ?>
</section>
<script src="/js/form_collapse.js"></script>
<?php endif; ?>
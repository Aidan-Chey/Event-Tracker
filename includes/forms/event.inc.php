<?php if(!empty($details)){ foreach($details as $key => $value){ $input[$key] = $value; } }
if(!empty($_POST)){ foreach($_POST as $key => $value){ $input[$key] = $value; } } ?>
<h3><?php if(!empty($type) && $type=='associated') echo 'Associated '; ?>Event Details</h3>
<?php if(varEquals($form,'edit')): ?>
<span class="error">* = Required</span><br>
<?php endif; ?>
<?php if(!empty($errors['general'])){ echo "<span class='error'>".$errors['general']."</span>";} ?>
<?php if(!empty($form) && $form=='view'): ?>
	<div>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/reference.html.php'; ?>
	</div>
	<div>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/requester.html.php'; ?>
	</div>
	<div>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/created.html.php' ?>
	</div>
	<div>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/status.html.php' ?>
	</div>
<?php endif; ?>
<div class="checkList">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/placeholder.html.php'; ?>
</div>
<div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/location.html.php' ?>
</div>
<div class="dateTime">
	<div>
		<div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/start_date.html.php' ?>
		</div>
		<div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/start_time.html.php' ?>
		</div>
	</div>
	<div>
		<div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/end_date.html.php' ?>
		</div>
		<div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/end_time.html.php' ?>
		</div>
	</div>
</div>
<?php if(varEquals($form,'edit')): ?>
	<script type="text/javascript">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/js/dateFiller.js'; ?>
	</script>
<?php endif; ?>
<div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/description.html.php' ?>
</div>
<script src="/js/event_valid.js" async></script>
<?php if( $form=='edit' && !empty($input['status']) ): ?>
	<input type='hidden' name='status' value='<?php htmlout( $input['status'] ); ?>'>
<?php endif; ?>
<?php if(!empty($type)): ?>
	<input type="hidden" name="type" value="<?php echo $type; ?>">
	<?php if($type == 'associate' && !empty($input['assoc_id'])): ?>
		<input type='hidden' name='assoc_id' value='<?php htmlout($input['assoc_id']); ?>'>
	<?php endif; ?>
<?php endif; ?>
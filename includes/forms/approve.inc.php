<?php 	if(!empty($details)){ foreach($details as $key => $value){ $input[$key] = $value; } }
if(!empty($_POST)){ foreach($_POST as $key => $value){ $input[$key] = $value; } } ?>
<label<?php if($form=='view'){echo ' for="approveCollapse" style="cursor: pointer;" onclick="formCollapse(\'approveCollapse\');"';} ?>>
	<h3>Manager's Approval<?php if($form=='view'){echo "<span id='approveCollapseSpan'> ↓</span>";} ?></h3>
</label>
<?php $role='approver';
if($form=='view'): ?>
<input type="checkbox" class="hide" id="approveCollapse" checked>
<?php 	endif; ?>
<form <?php if($form=='edit'){ echo "action='#confirm' method='post'"; }?>>
	<?php if($form=='view'): ?>
	<div class="group user">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/approvals/name.html.php' ?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/approvals/date.html.php' ?>
	</div>
	<?php endif; ?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/approvals/feedback.html.php' ?>
	<?php if($form=='edit'): ?>
	<input type="hidden" name="event_id" value="<?php if(!empty($input['id'])){ echo $input['id']; }?>">
	<?php if(!empty($errors['general'])){ echo "<br><article class='error'>".$errors['general']."</article>"; }?>
	<p>
		<button name="approve">Approve Event</button>
		<button name="decline">Decline Event</button>
	</p>
	<?php endif; ?>
</form>
<h2 id="Form_Top">Draft Event</h2>
<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/hotkeys.inc.html'; ?>
<form method="post" id="request">
	<input type="hidden" name="id" value="<?php htmlout($details['id']); ?>">
	<?php if(!empty($details['type'])){$type=$details['type'];}?>
	<?php $form='edit';
	$creating=TRUE; ?>
	<section id="event" class='event'>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/event.inc.php'; ?>
	</section>
	<section class="center foot">
		<button id="submit" formaction="/Submissions/New/" name="create">Submit</button>
		<button id="save" formaction="?#" formnovalidate name="save">Save</button>
		<button type="reset">Reset</button>
	</section>
</form>
<h2 id="Form_Top">Event Request Form</h2>
<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/hotkeys.inc.html'; ?>
<form method="post" id="request">
	<section id="event" class='event'>
		<?php if(!empty($_SESSION['messages'])) echo "<span class='error'>".$_SESSION['messages']."</span>"; ?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/event.inc.php'; ?>
	</section>
	<section class="center foot">
		<button id='submit' name="create">Submit</button>
		<input type="hidden" name="type" value="<?php if(!empty($type)){ echo $type; } ?>">
		<button id='save' formnovalidate name="save">Save Draft</button>
		<button type="reset">Reset</button>
	</section>
</form>
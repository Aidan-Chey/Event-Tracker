<?php	if(!empty($details)){ foreach($details as $key => $value){ $input[$key] = $value; } }
if(!empty($_POST)){ foreach($_POST as $key => $value){ $input[$key] = $value; } } ?>
<h3>Event Summary</h3>
<div class="details">
	<div>
		<div class="name">
			<?php  include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/requester.html.php' ?>
		</div>
		<div>
			<?php  include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/created.html.php' ?>
		</div>
		<div>
			<?php  include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/type.html.php' ?>
		</div>
	</div>
	<fieldset>
		<legend>Reference Numbers</legend>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/reference.html.php' ?>
	</fieldset>
</div>
<div class="dateTime">
	<?php  include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/start.html.php' ?>

	<?php  include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/end.html.php' ?>
</div>
<div class="textBox">
	<?php  include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/events/description.html.php' ?>
</div>
<?php //List available drafts in a table ?>
<section>
	<?php if(!empty($_SESSION['messages'])) echo "<br><span class='error'>".$_SESSION['messages']."</span>"; ?>
	<?php if(!empty($drafts)): ?>
	<h3>Saved Drafts</h3>
	<form>
		<?php $table = createTableData($drafts);
		include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>
		<p>
			<button formaction="#Form_Top" formmethod="get" name="edit">Edit</button>
			<label class="button pointer" for="button_delete">Delete</label>
			<input id="button_delete" type="checkbox" class="hide" checked>
			<button formaction="?#" formmethod="post" name="delete">Confirm Delete</button>
			<a class="button" href="/">Cancel</a>
		</p>
	</form>
	<?php else: ?>
	<h3>You have no stored drafts. To make one, save an event instead of submitting it.</h3>
	<?php endif; ?>
</section>
<style type="text/css">
</style>
<section id='Results'>
	<form id="audit" method="post" action="#Transaction">
	<?php $table =  createTableData($audits);
	include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>

		<?php if(!empty($errors['general'])): ?>
			<br><span class="error"><?php echo $errors['general']; ?></span>
		<?php endif; ?>
		<p>
			<button name="view">View</button>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/copyElement.inc.php'; ?>
		</p>
	</form>
</section>
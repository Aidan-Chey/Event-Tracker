<?php //html to display the results of the summary report ?>

<?php if(!empty($summary)): ?>
	<section id='summary'>
		<h3>Events Summary</h3>
		<form method="post" action="/Search/#Form_Top">
			<?php $table = createTableData($summary);
			include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>
			<p>
				<button name="view">View Event</button>
				<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/copyElement.inc.php'; ?>
			</p>
		</form>
	</section>
<?php else: ?>
	<section>
		<h3>No events fell within specified dates.</h3>
		<p class="noPrint">
			<a class="button" href="/">Cancel</a>
		</p>
	</section>
<?php endif; ?>
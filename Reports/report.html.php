<h2>Event Tracker Report</h2>
<?php if(!empty($events)): ?>
	<section>
		<h3>
		<?php switch($report){
			case 'pending': echo "Pending Events"; break;
			case 'approved': echo "Approved Events"; break;
			case 'accountable': echo "No Accountability Assigned"; break;
			case 'changes': echo "Changed Events"; break;
			case 'declined': echo "Declined Events"; break;
		} ?>
		</h3>
		<?php if(!empty($_SESSION['messages'])): ?>
			<div class="error"><?php echo $_SESSION['messages']; ?></div>
		<?php endif; ?>
		<form method="post" action="/Search/#Form_Top">
			<?php $table = createTableData($events);
			include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>
			<p class="noPrint">
				<button name="view">View Event</button>
				<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/copyElement.inc.php'; ?>
			</p>
		</form>
	</section>
<?php else: ?>
	<section>
		<h3>No events met the criteria</h3>
		<p class="noPrint">
			<a class="button" href="/">Cancel</a>
		</p>
	</section>
<?php endif; ?>
<h2>Confirmation</h2>
<?php if(!empty($events)): ?>
	<section id="search_table">
		<h3>Search Results</h3>
		<form action="#Form_Top" method="get">
			<?php $table = createTableData($events);
			include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>
			<p>
				<button <?php if(!userHasRole(array('confim','admin'))) echo 'Disabled title="You need to be Verified"'; ?>>Show</button>
				<a class="button" href="/">Cancel</a>
				<?php if(!empty($_SESSION['messages'])) echo "<br><span class='error'>".$_SESSION['messages']."</span>"; ?>
			</p>
		</form>
	</section>
<?php else: ?>
	<section>
		<h3>No events awaiting confirmation</h3>
		<p>
			<a class="button" href="/">Cancel</a>
			<?php if(!empty($_SESSION['messages'])) echo "<br><span class='error'>".$_SESSION['messages']."</span>"; ?>
		</p>
	</section>
<?php endif; ?>
<?php if(!empty($_GET['listSelect'])):
	try {
		$s = $pdo->query(
			"SELECT $mysql_event_display
			FROM `events`
			WHERE `id` = '".$_GET['listSelect']."' AND `status` = 'apply'
			LIMIT 1");
	} catch (PDOException $e) {
		$error = 'Error retrieving event for confimation. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}
	if($s->rowCount() > 0):
		$details = $s->fetchAll(PDO::FETCH_ASSOC)[0];
		$type=$details['type']; ?>

		<a name="Form_Top"></a>
		<h2>Event Details</h2>
		<section id="event" class='event'>
			<?php $form='view'; ?>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/event.inc.php'; ?>
		</section>
		<section id="confirm">
			<?php $form='edit'; ?>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/confirm.inc.php'; ?>
		</section>
<script src="/js/form_collapse.js"></script>
	<?php else: ?>
		<section>
			<h3>Selected event not awaiting confirmation</h3>
		</section>
	<?php endif; ?>
<?php endif; ?>
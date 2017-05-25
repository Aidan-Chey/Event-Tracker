<h2 class="center noPrint">Search</h2>
<section id="criteria" class='noPrint'>
	<form action="#Results" method="get">
		<div>
			<div>
				<div>
					<div class="criteria-element">
						<label for="search_requester">Requester Name: </label>
						<input type="search" name="requester" id="search_requester" value="<?php if(!empty($_GET['requester'])){ htmlout($_GET['requester']); }?>">
						<?php if(!empty($errors['requester'])) echo "<br><span class='error'>".$errors['requester']."</span>"?>
					</div>
				</div>
				<div>
					<div class="criteria-element">
						<label for="search_id">Event ID: </label>
						<input type="number" name="id" id="search_id" min="0" value="<?php if(isset($_GET['id']) && $_GET['id'] !== ""){ htmlout($_GET['id']); }?>">
						<?php if(!empty($errors['id'])) echo "<br><span class='error'>".$errors['id']."</span>"?>

					</div>
				</div>
			</div>
			<div>
				<div>
					<div class="criteria-element">
						<label for="search_date">Date (approx): </label>
						<input id="search_date" type="month" name="date" placeholder="YYYY-MM" value="<?php if(isset($_GET['date'])){ htmlout($_GET['date']); }?>">
						<?php if(!empty($errors['date'])) echo "<br><span class='error'>".$errors['date']."</span>"?>
					</div>
				</div>
				<div>
					<div class="criteria-element">
						<label for="search_archives">Search Archives: </label>
						<div class="checkbox-container">
							<input class="checkbox-input" type="checkbox" name="archives" id="search_archives" <?php if(isset($_GET['archives'])){ echo "checked"; }?> />
							<label for="search_archives" class="checkbox-label">
								<span class="checkbox-checkmark">✔</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p>
			<button name="Asked">Search</button>
			<a class="button" href="/Search">Clear</a>
			<a class="button" href="/">Cancel</a>
			<?php if(!empty($_SESSION['messages'])) echo "<br><span class='error'>".$_SESSION['messages']."</span>"; ?>
		</p>
	</form>
</section>
<?php if(isset($_GET['Asked'])): ?>
	<?php if(!empty($events)): ?>
	<section id="Results" class='noPrint'>
		<h3>Search Results</h3>
		<form action="#Form_Top" method="post">
			<?php $table = createTableData($events);
			include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>
			<p>
				<button name="view" onclick="if(table.querySelector('.selectedRow') === null) { console.log('cancelled'); return false; }">View Event</button>
				<?php if(!isset($_GET['archive']) && !userHasRole('')): ?>
				<button name="edit" onclick="if(table.querySelector('.selectedRow') === null) { console.log('cancelled'); return false; }">Edit Event</button>
				<?php endif; ?>
				<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/copyElement.inc.php'; ?>
			</p>
		</form>
	</section>
	<?php else: ?>
	<section id="Results">
		<h3>No results found for selected search criteria.</h3>
	</section>
<?php endif; endif; ?>

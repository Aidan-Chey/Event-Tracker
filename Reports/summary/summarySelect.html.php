<?php //HTML to allow users to select a date range for the summary report ?>
<section id='event'>
<h3>Summary Date Selection</h3>
	<?php if(!empty($_SESSION['messages'])): ?>
		<div class="error"><?php echo $_SESSION['messages']; ?></div>
	<?php endif; ?>

	<form method="get" action="">
		<div class="dateTime" style="margin:auto;">
			<div>
				<div>
					<div title="Start of timespan." class="form-element">
						<label for="field_start">Start Date: *</label>
						<input required name="start" id="field_start" value="<?php if(!empty($_GET['start'])) { date_out($_GET['start']); }else{ date_out(strtotime(' 6 weeks ago'));} ?>">
						<?php if(!empty($errors['start'])) echo "<br><span class='error'>".$errors['start']."</span>"?>
					</div>
				</div>
			</div>
			<div>
				<div>
					<div title="End of timespan." class="form-element">
						<label for="field_end">End Date: *</label>
						<input required name="end" id="field_end" value="<?php if(!empty($_GET['end'])) { date_out($_GET['end']); }else{ date_out(strtotime('now'));} ?>">
						<?php if(!empty($errors['end'])) echo "<br><span class='error'>".$errors['end']."</span>"?>
					</div>
				</div>
			</div>
		</div>
		<p class="noPrint">
			<button name="Summary">Submit</button>
		</p>
	</form>
</section>
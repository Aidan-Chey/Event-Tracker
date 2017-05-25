<?php //HTML to allow user to select an event to build report on. ?>
<section id='event'>
	<h3>Select report timespan</h3>
	<?php if(!empty($_SESSION['messages'])): ?>
		<div class="error"><?php echo $_SESSION['messages']; ?></div>
	<?php endif; ?>
	<p>
		<form method="get" action="#Lengths">
			<div class="dateTime" style="margin:auto">
				<div>
					<div>
						<div title="Start of timespan." class="form-element">
							<label for="field_start">Start Date: *</label>
							<input id="field_start" name="begin" required value='<?php if(!empty($_GET['begin'])) { date_out($_GET['begin']); }else{ date_out(strtotime('6 weeks ago')); } ?>'>
							<?php if(!empty($errors['begin'])) echo "<br><span class='error'>".$errors['begin']."</span>"?>
						</div>
					</div>
				</div>
				<div>
					<div>
						<div title="End of timespan." class="form-element">
							<label for="field_finish">End Date: *</label>
							<input id="field_finish" name="end" required  value='<?php if(!empty($_GET['end'])) { date_out($_GET['end']); }else{ date_out(strtotime('now')); } ?>'>
							<?php if(!empty($errors['end'])) echo "<br><span class='error'>".$errors['end']."</span>"?>
						</div>
					</div>
				</div>
			</div>
			<p class="noPrint">
				<button name="Length">Submit</button>
			</p>
		</form>
	</p>
</section>
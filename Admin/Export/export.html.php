<h2>Register Export</h2>
<section>
	<h3>Select critera to limit exported XML</h3>
	<form action="download.php" method="Get">
	<style type="text/css"> .criteria-element {text-align: center;} </style>
		<div>
			<div class="criteria-element">
				<label for="export_approved">Approved: </label>
				<div class="checkbox-container">
					<input class="checkbox-input" type="checkbox" name="aproved" id="export_approved" autofocus  checked />
					<label class="checkbox-label" for="export_approved">
						<span class="checkbox-checkmark">✔</span>
					</label>
				</div>
			</div>
		</div>
		<div>
			<div class="criteria-element">
				<label for="export_onwards">Today, onwards</label>
				<div class="checkbox-container">
					<input class="checkbox-input" type="checkbox" name="onwards" id="export_onwards" autofocus checked />
					<label class="checkbox-label" for="export_onwards">
						<span class="checkbox-checkmark">✔</span>
					</label>
				</div>
			</div>
		</div>
		<p>
			<button name="export">Submit</button>
			<?php if(!empty($_SESSION['messages'])): ?>
				<br><span class="error"><?php htmlout($_SESSION['messages']); ?></span>
			<?php endif; ?>
		</p>
	</form>
</section>
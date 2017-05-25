<h2>Audit</h2>
<section id='criteria' class="noPrint">
	<?php if(!empty($_SESSION['messages'])): ?>
		<br><span class="error"><?php echo $_SESSION['messages']; ?></span>
	<?php endif; ?>
	<form action="#Results" method="get">
		<div>
			<div>
				<div>
					<div class="criteria-element">
						<label for="audit_ID">Transaction ID: </label>
						<input type="number" name="id" id="audit_ID" min="0" value="<?php if(isset($_GET['id']) && $_GET['id'] !== ""){ htmlOut($_GET['id']); }?>">
						<?php if(!empty($errors['id'])) echo "<br><span class='error'>".$errors['id']."</span>"?>
					</div>
				</div>
				<div>
					<div class="criteria-element">
						<label for="audit_name">Name: </label>
						<input type="search" name="name" id="audit_name" value="<?php if(!empty($_GET['name'])){ htmlOut($_GET['name']); }?>">
						<?php if(!empty($errors['name'])) echo "<br><span class='error'>".$errors['name']."</span>"?>
					</div>
				</div>
			</div>
			<div>
				<div>
					<div class="criteria-element">
						<label for="audit_item">Item ID: </label>
						<input type="number" name="item_id" id="audit_item" min="0" value="<?php if(isset($_GET['item_id']) && $_GET['item_id'] !== ""){ htmlOut($_GET['item_id']); }?>">
						<?php if(!empty($errors['item_id'])) echo "<br><span class='error'>".$errors['item_id']."</span>"?>
					</div>
				</div>
				<div>
					<div class="criteria-element">
						<label for="audit_date">Date (approx.): </label>
						<input id="audit_date" type="month" name="ts" placeholder="Year and Month" value="<?php if(!empty($_GET['ts'])) { htmlOut(date('Y-m',strtotime($_GET['ts']))); } ?>">
						<?php if(!empty($errors['ts'])) echo "<br><span class='error'>".$errors['ts']."</span>"?>
					</div>
				</div>
			</div>
		</div>
		<p>
			<button name="Asked">Search</button>
			<a class="button" href="/Audit">Clear</a>
			<a class="button" href="/">Cancel</a>
		</p>
	</form>
</section>
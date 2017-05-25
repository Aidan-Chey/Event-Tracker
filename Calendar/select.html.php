<?php
//code snippet constructing the where statement
include 'eventWhere.php';
?>
<style type="text/css">
/*added css inline to prevent need for creating new style sheet for this*/
	#calendarSelect form{text-align: center;}
	#calendarSelect form div{margin: 1em 0; text-align: left;}
	#calendarSelect form select{width: 9em; height: 1.8em;}
	@media(min-width:550px){
		#calendarSelect form div{margin: 1em 2em;display: inline-block;}
	}
</style>
<section id='calendarSelect'>
	<form method="post">
		<?php if(!empty($_SESSION['messages'])): ?>
		<div class="error"><?php echo $_SESSION['messages']; ?></div>
		<?php endif; ?>
		<h3>Select Calendar Type</h3>
		<div>
			<label><b>Intractability:</b><br>
				<select name="inter">
					<option>Interactive</option>
					<option>Static</option>
				</select>
		</div>
		<div>
			<label><b>Time Spans:</b><br>
				<select name="time">
					<option>Monthly</option>
					<option>Weekly</option>
					<option>Daily</option>
				</select>
			</label>
		</div>
		<div>
			<label><b>Information:</b><br>
				<select name="info">
					<option value="Full_Portfolio">Full Portfolio</option>
					<?php foreach ($locations as $value){
						echo "<option>$value</option>";
					} ?>
				</select>
			</label>
		</div>
		<p>
			<button>Submit</button>
		</p>
	</form>
</section>
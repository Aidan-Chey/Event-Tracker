<?php //HTML to display the results of the approval length?>
<h2>Event Tracker Report</h2>
<?php if(!empty($averages) && !empty($report) && $report == 'length'): ?>
<style type="text/css">
	.flow{
	text-align: center;
	}
	.flow form{
	display: inline-table;
	background-color: hsl(210,75%,45%);
	width: 9em;
	height: 9em;
	margin: 5px;
	padding: 5px;
	cursor: pointer;
	}
	.flow form:active{
	background-color: hsl(210,75%,40%);
	}
	.flow h4{
	font-size: 140%;
	margin: .5em 0;
	}
	.flow p{
	font-size: 80%;
	}
</style>
<section id="Lengths" class="basic_form">
	<h3>Average Approval Lengths (Days)</h3>
	<?php if(!empty($_SESSION['messages'])): ?>
	<div class="error"><?php echo $_SESSION['messages']; ?></div>
	<?php endif; ?>
	<div class="flow"><?php $convert = array(
		'confirmer' => array('head'=>'Confirmation','title'=>'Average number of days from its latest edit to when it was confirmed')
		,'approver' => array('head'=>'Approval','title'=>'Average number of days from when it was coordinator reviewed to when it was approved')
	); ?>
	<?php foreach ($averages as $stage => $data):
		if(!empty($data['averageDays'])): ?>
		<form method="post" action="#Results" onClick="this.submit();" title="<?php echo $convert[$stage]['title']; ?>">
			<h4><?php echo $data['averageDays']; ?></h4>
			<span><?php echo $convert[$stage]['head']; ?></span>
			<p><?php echo $data['count']." Events"; ?></p>
			<input type="hidden" name="selection" value="<?php echo $stage; ?>">
			<?php foreach ($data['IDs'] as $id => $duration): ?>
			<input type="hidden" name="<?php echo "IDs[]"; ?>" value="<?php echo $duration; ?>">
			<?php endforeach ?>
		</form>
	<?php endif; endforeach; ?>
	</div>
</section>
<?php else: ?>
<section>
	<?php if(!empty($_SESSION['messages'])): ?>
		<div class="error"><?php echo $_SESSION['messages']; ?></div>
	<?php endif; ?>
	<h3>No event information to display</h3>
	<p class="noPrint">
		<a class="button" href="/">Cancel</a>
	</p>
</section>
<?php endif; ?>
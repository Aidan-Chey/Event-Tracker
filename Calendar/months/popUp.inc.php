<article>
	<label for='details_<?php echo $vId.'_'.$month; ?>'>
		<?php if(empty($value['spoa'])){ echo "<b>Requester: </b>"; htmlOut($value['requester']);} ?>
		<span><?php htmlOut($value['description']); ?>.</span>
	</label>
	<input type='checkbox' name='details' class='hide' id='details_<?php echo $vId.'_'.$month; ?>' onclick="itemClick(this)" checked>
	<div>
		<form action="/Search/?id=<?php echo $vId; ?>&Asked#event" method="post">
			<input type="hidden" name="view">
			<a onclick="this.parentNode.submit();" style="font-weight:bold;cursor:pointer;border-bottom:1px solid #8F1FAE;color:#8F1FAE;">View Event</a>
		</form>
		<b>Start:</b> <?php datetime_out($value['start']); ?>.
		<br><b>Finish:</b> <?php datetime_out($value['end']); ?>.
		<br><b>Duration:</b> <?php echo $value['duration'].' Days'; ?>.
		<br><b>Description:</b> <?php htmlOut($value['description']); ?>.
	</div>
</article>
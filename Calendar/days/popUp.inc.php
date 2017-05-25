<div <?php //determin how to anchor the event's popup
	$new_pop_up_id = uniqid($id.'_'.$date);
	 if(!empty($weekCycles) && ($weekCycles/3*2) < $i){ echo "class='anchorLeft'"; }
?>>
	<article>
		<b><u>Event</u></b>
		<label for='details_<?php echo $new_pop_up_id ?>'>
			<?php echo "<b>Requester: </b>"; htmlOut($events[$date][$id]['requester']);
			if(!empty($events[$date][$id]['description'])){ echo "<span>".$events[$date][$id]['description']."</span>";} ?>
		</label>
		<input type='checkbox' name='details' class='hide' id='details_<?php echo $new_pop_up_id ?>' onclick="itemClick(this)" checked>
		<div <?php //determin how to anchor the popup's popup
			 if(!empty($weekCycles) && ($weekCycles/2) < $i){ echo "class='anchor2Left'"; }
		?>>
			<form action="/Search/?id=<?php echo $id; ?>&Asked#event" method="post">
				<input type="hidden" name="view">
				<a onclick="this.parentNode.submit();" style="font-weight:bold;cursor:pointer;border-bottom:1px solid #8F1FAE;color:#8F1FAE;">View Event</a>
			</form>
			<br><b>Start:</b> <?php date_out($events[$date][$id]['start']); ?>
			<br><b>End:</b> <?php date_out($events[$date][$id]['end']); ?>
			<br><b>Duration:</b> <?php echo $events[$date][$id]['duration'].' Days'; ?>
			<br><b>Description:</b> <?php htmlOut($events[$date][$id]['description']); ?>
		</div>
	</article>
	<?php $pink = 0;
	foreach ($events[$date] as $rId => $rContent): ?>
		<?php if((!empty($rContent['assoc_id']) && $rContent['assoc_id'] == $id)): ?>
			<?php $pink = 1;
			$piggy_popup_id = uniqid($rId.'_'.$date); ?>
			<article>
				<?php if(!isset($title)): $title = ''; ?><b><u>Associated</u></b><?php endif; ?>
				<label for='details_<?php echo $piggy_popup_id; ?>'>
					<?php echo "<b>Requester: </b>"; htmlOut($rContent['requester']);
					if(!empty($events[$date][$id]['description'])){ echo "<span>".$events[$date][$id]['description']."</span>";} ?>
				</label>
				<input type='checkbox' name='details' class='hide' id='details_<?php echo $piggy_popup_id; ?>' onclick="itemClick(this)" checked>
				<div <?php //determin how to anchor the popup's popup
				 if(!empty($weekCycles) && ($weekCycles/2) < $i){ echo "class='anchor2Left'"; }
			?>>
					<form action="/Search/?id=<?php echo $rId; ?>&Asked#event" method="post">
						<input type="hidden" name="view">
						<a onclick="this.parentNode.submit();" style="font-weight:bold;cursor:pointer;border-bottom:1px solid #8F1FAE;color:#8F1FAE;">View Event</a>
					</form>
					<b>Start:</b> <?php date_out($rContent['start']); ?>.
					<br><b>End:</b> <?php date_out($rContent['end']); ?>.
					<br><b>Duration:</b> <?php echo $rContent['duration'].' Days'; ?>.
					<br><b>Description:</b> <?php htmlOut($rContent['description']); ?>.
				</div>
			</article>
		<?php endif; ?>
	<?php endforeach;
	unset($title); ?>
</div>
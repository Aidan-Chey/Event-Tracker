<?php
//number of cells between the axis (5 weeks and 2 days)
$weekCycles = 37;

function curDate($date,$day){ return date('Y-m-d',strtotime($date.'-'.$day)); }
function taken($cell,$key,$taken){
	if(isset($taken["$key"])){return true;}
	foreach($taken as $k){
		if($k['cellpos'] == $cell && !isset($k['expired'])){return true;}
	}
	return false;
}
include $_SERVER['DOCUMENT_ROOT'].'/includes/number_word.inc.php'; ?>


<h2 style="@media(print){whitespace:nowrap;}">Events Calendar - <?php include $_SERVER['DOCUMENT_ROOT'].'/Calendar/info.inc.php'; ?> - Daily</h2>
<script>
function expandCell(duration){
	document.write('<span id="temp" style="display:none"></span>');
	var temp = document.getElementById('temp');
	var cell = temp.parentNode;
	cell.setAttribute('colspan',Math.floor(duration));
	//cell.setAttribute('style','background-color: '+color);
	cell.removeChild(temp);
};
</script>
<?php //print_r($events); exit; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/Calendar/key.inc.php'; ?>
<table id="calendar">
	<thead>
		<tr>
			<th class="yHeaders"></th>
			<?php $weekPos = 0;
			 for ($i=0; $i < $weekCycles; $i++):
				if($weekPos > 6){$weekPos = 0;} ?><!--
				 --><th><?php echo $weekDays["$weekPos"]; ?></th>
			<?php $weekPos++; endfor; ?>
			<th class="yHeaders"></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$date = date('Y-m',$timespan['start']);
		$taken = array();
		$minimumRows = 1;
		while($date <= date('Y-m',$timespan['end'])):
			//declare amount of rows to add to the month with a minimum of $minimumRows
			if(!empty($monthRows["$date"]) && $monthRows["$date"] > $minimumRows){
				$cellRows = $monthRows["$date"];
			}else{$cellRows = $minimumRows;}

			$firstDay = date('D',strtotime($date));
			$monthMax = date('t',strtotime($date)); ?>

			<tr class="calendar-first">
				<th rowspan="<?php echo $cellRows+1; ?>" class="yHeaders"><?php echo date('M-y',strtotime($date)); ?></th>
				<?php
				$weekPos = 0;
				$monthPos = 0;

				for ($i=0; $i < $weekCycles; $i++):
					//resets week count
					if($weekPos > 6){$weekPos = 0;}
					//starts the counting of month days
					if ($firstDay == $weekDays["$weekPos"] && $monthPos < 1){$monthPos = 1;}
					?>
					<th <?php if(!$monthPos > 0 || $monthPos > $monthMax){echo 'class="calendar-background"';} ?>>
						<?php //fills cell if week day equals
						 if($monthPos > 0 && $monthPos <= $monthMax){ echo $monthPos; }?>
					</th>
				<?php if($monthPos > 0){$monthPos++;} $weekPos++; endfor; ?>
				<th rowspan="<?php echo $cellRows+1; ?>" class="yHeaders" >
					<?php echo date('M-y',strtotime($date)); ?>
				</th>
			</tr>
		<?php for ($a=0; $a < $cellRows; $a++):
		 $cellPos = numberToWord($a); ?>
		<tr>
			<?php $weekPos = 0; $monthPos = 0;
			for ($i=0; $i < $weekCycles; $i++):
				//resets week count
				if($weekPos > 6){$weekPos = 0;}
				//starts the counting of month days
				if ($firstDay == $weekDays["$weekPos"] && $monthPos < 1) {$monthPos = 1;} ?>
				<td <?php if(!$monthPos > 0 || $monthPos > $monthMax){echo 'class="calendar-background"';} ?>>
					<?php //fills cell if week days equals
					if($monthPos > 0 && $monthPos <= $monthMax): ?>

						<?php if(!empty($taken)){
							foreach($taken as $id => $contents){
								if($monthPos == 1 && !isset($contents['expired']) && !isset($taken["$id"]['cellpos'])){
									foreach ($taken as $k => $v) {
										if($v['cellpos'] == $cellPos){
											break 2;
										}
									}
									$duration = (strtotime($contents['expire'])-strtotime(date('Y-m-d',strtotime($date))))/60/60/24+1;
									if($duration >= 1){
										if($duration >= $monthMax){
											$duration=$monthMax;
										}
										include 'calendarCell.inc.php';
										$taken["$id"]['cellpos'] = $cellPos;
										$i += ($duration-1);
										$monthPos += (floor($duration-1));
									}
								}
							}
						}
						$curDate = curDate($date,$monthPos);
						?>

						<?php if(!empty($events[$date])){
							foreach ($events[$date] as $key => $event){
								$eventStart = date('Y-m-d',strtotime($event['start']));
								$eventEnd = date('Y-m-d',strtotime($event['end']));
								if ($event['duration'] > 0
								&& (strtotime($curDate) == strtotime($eventStart) || (strtotime($eventStart) < strtotime($date) && strtotime($eventEnd) >= strtotime($curDate) && $monthPos == 1))
								&& !taken($cellPos,$key,$taken)) {
									$colour = $event['colour'];

									if(strtotime($eventStart) == strtotime($curDate)) {
										if(strtotime($eventEnd) > strtotime(curDate($date,$monthMax))) {
											$duration = $monthMax-$monthPos+1;
										}elseif(strtotime($eventEnd) <= strtotime(curDate($date,$monthMax))) {
											$duration = (strtotime($eventEnd) - strtotime($eventStart))/86400+1;
										}
									}elseif(strtotime($eventStart) < strtotime($date)) {
										if(strtotime($eventEnd) > strtotime(curDate($date,$monthMax))) {
											$duration = $monthMax;
										}elseif(strtotime($eventEnd) <= strtotime(curDate($date,$monthMax))) {
											$duration = date('d',strtotime($eventEnd));
										}
									}

									$taken["$key"]= array('cellpos' => $cellPos, 'expire' => $eventEnd, 'color' => $colour);
									$id = $key;
									include 'calendarCell.inc.php';
									$i += ($duration-1);
									$monthPos += ($duration-1);
								}
							}
						} ?>

						<?php foreach($taken as $id => $contents){
							if($contents['expire'] == $curDate
								&& !isset($taken["$id"]['expired'])
								&& $contents['cellpos'] == $cellPos){
									$taken["$id"]['expired'] = true;
									unset($events[$date]["$id"]);
							}
						} ?>

					<?php endif; ?>
				</td>
			<?php if($monthPos > 0){$monthPos++;} $weekPos++; endfor; ?>
		</tr>
		<?php endfor;
		foreach($taken as $id => $contents){
			if(isset($contents['expired'])){unset($taken["$id"]);}
			if(isset($taken["$id"]['cellpos'])){$taken["$id"]['cellpos'] = null;}
		}
		$date=date('Y-m',strtotime($date.'+ 1 month'));
		endwhile; ?>
	</tbody>
	<tfoot>
		<tr>
			<th class="yHeaders"></th>
			<?php $weekPos = 0;
			 for ($i=0; $i < $weekCycles; $i++):
				if($weekPos > 6){$weekPos = 0;} ?>
				<th><?php echo $weekDays["$weekPos"]; ?></th>
			<?php $weekPos++; endfor; ?>
			<th class="yHeaders"></th>
		</tr>
	</tfoot>
</table>

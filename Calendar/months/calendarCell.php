<?php
$ready = array();
$placeholder = array();
$approved = array();
$confirmed = array();
$declined = array();

foreach ($events[$month] as $rId => $event){
	if(!empty($event) && $event['location'] == $location){
		$startDate = date('Y-m',strtotime($event['start']));
		$finishDate = date('Y-m',strtotime($event['end']));
		$popUpId = $event['location'].'_'.$month;

		if($startDate == $month || $finishDate == $month || ($startDate < $month && $finishDate > $month)){

			if($event['type'] == 'new'){
				if($event['status'] == 'decline') $declined[$rId]=$event;
				elseif($event['status'] == 'approve') $approved[$rId]=$event;
				elseif($event['placeholder'] == 't') $placeholder[$rId]=$event;
				else $confirmed[$rId]=$event;
			}
		}
	}
}
foreach ($states as $state => $colour):
	if(!empty($$state)): ?>
		<label for="<?php echo $state.'_'.$popUpId; ?>" style="background-color: <?php echo $colour; ?>;"></label>
		<input type='checkbox' name='pop_up' class='hide' id='<?php echo $state.'_'.$popUpId; ?>' onclick="itemClick(this)" checked>
		<div>
			<?php foreach ($$state as $vId => $value){
				include 'popUp.inc.php';
			} ?>
		</div>
	<?php endif;
endforeach; ?>

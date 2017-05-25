<?php $popUpId = $id.'_'.$date; $uniqueid = uniqid($id); ?>
<label for="<?php echo $popUpId; ?>" id="<?php echo $uniqueid; ?>" <?php echo "style='background-color: ".$events[$date][$id]['colour']."'";?>><?php htmlOut($events[$date][$id]['location'].' - '.$events[$date][$id]['description']); ?></label>
<input type='checkbox' name='pop_up' class='hide' id='<?php echo $popUpId; ?>' onclick="itemClick(this)" checked>
<?php include 'popUp.inc.php';
//Script to extend the event's cell to match it's duration ?>
<script type='text/javascript'>expandCell("<?php echo $duration ?>");</script>
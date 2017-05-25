<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/status.php'; ?>
<div class="form-element">
	<label for="field_stage">Status: </label>
	<input disabled id="field_stage" value="<?php echo status($input['status'],array('placeholder'=>$input['placeholder'])); ?>">
</div>
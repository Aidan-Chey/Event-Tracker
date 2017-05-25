<?php //HTML to show the event's location ?>
<div class="form-element">
	<label for="field_location">Location: <?php requStar($form); ?></label>
	<input <?php if(!empty($form) && $form == 'edit'){ echo "required";}else{ echo "disabled"; }?> name="location" id="field_location" spellcheck="true" value="<?php if(isset($input['location'])){htmlout($input['location']);} ?>">
	<?php if(!empty($form) && $form == 'edit'){
		if(!empty($errors['location'])){ echo "<span class='error'>".$errors['location']."</span>"; }
	} ?>
</div>
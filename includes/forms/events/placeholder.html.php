<?php //HTML to determin if event is placeholder ?>
<div class="form-element">
	<label for="field_placeholder">Placeholder:</label>
	<div class="checkbox-container">
		<input class="checkbox-input" type="checkbox" name="placeholder" id="field_placeholder" <?php if( !empty($form) && $form == 'view' ){ echo "disabled"; } ?> <?php if(isset($input) && $input['placeholder'] == 't' ){ echo "checked"; }?> />
		<label class="checkbox-label" for="field_placeholder">
			<span class="checkbox-checkmark">✔</span>
		</label>
	</div>
	<?php if(!empty($form) && $form == 'edit'){
		if(!empty($errors['placeholder'])){ echo "<span class='error'>".$errors['placeholder']."</span>"; }
	} ?>
</div>
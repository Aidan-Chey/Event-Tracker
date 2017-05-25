<div class="form-element">
	<label for="field_requester">Name of requester: <?php requStar($form); ?></label>
	<input <?php
		if(!empty($form) && $form == 'edit'){ echo "required";}
		else{ echo "disabled"; }?> name="requester" id="field_requester" spellcheck="true" value="<?php
			if(isset($input['requester'])){ htmlout($input['requester']); }
			elseif(!empty($_SESSION['user']['name']) && $form=='edit'){ htmlout($_SESSION['user']['name']); } ?>
		">
	<?php if(!empty($form) && $form == 'edit'){
		if(!empty($errors['requester'])){ echo "<span class='error'>".$errors['requester']."</span>"; }
	} ?>
</div>
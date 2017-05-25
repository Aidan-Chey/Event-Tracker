<div class="form-element">
	<label for="field_name">By:</label>
	<?php if(empty($form)): ?>
		<p>form variable not specified.</p>
	<?php else: ?>
	<input disabled name="name" id="field_name" value="<?php
		if(!empty($role)){
			if($role=='confirmer' && !empty($input['confirmer_name'])){ htmlout($input['confirmer_name']); }
			elseif($role=='approver' && !empty($input['approver_name'])){ htmlout($input['approver_name']); }
		}?>">
	<?php if(!empty($form) && $form=='edit' && !empty($errors['name'])) echo "<br><span class='error'>".$errors['name']."</span>"; ?>
	<?php endif; ?>
</div>
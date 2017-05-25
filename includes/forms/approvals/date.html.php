<div class="form-element">
	<label for="field_date">Date:</label>
	<?php if(empty($form)): ?>
	<p>form date not specified.</p>
	<?php else: ?>
	<input disabled name="date" id="field_date" value="<?php if(!empty($role)){
			if($role=='confirmer' && !empty($input['confirmer_checked'])){ date_out($input['confirmer_checked']); }
			elseif($role=='approver' && !empty($input['approver_checked'])){ date_out($input['approver_checked']); }
		}?>">
	<?php if(!empty($form) && $form=='edit' && !empty($errors['date'])){ echo "<br><span class='error'>".$errors['date']."</span>";} ?>
	<?php endif; ?>
</div>
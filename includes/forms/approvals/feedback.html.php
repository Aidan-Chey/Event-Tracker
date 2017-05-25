<div class="form-element">
	<label for="field_feedback">Feedback: </label>
	<?php if(empty($form)): ?>
		<p>form variable not specified.</p>
	<?php else: ?>
	<textarea <?php if($form=='view'){ echo "disabled"; }else{echo "placeholder='Manditory if Declined'";}?> name="feedback" rows="3" id="field_feedback" spellcheck="true" ><?php
		if(!empty($form) && $form=='edit' && !empty($input['feedback'])){ htmlout($input['feedback']);}
		elseif(!empty($role)){
			if($role=='confirmer' && !empty($input['confirmer_feedback'])){ htmlout($input['confirmer_feedback']); }
			elseif($role=='approver' && !empty($input['approver_feedback'])){ htmlout($input['approver_feedback']); }
		}?></textarea>
	<?php if($form=='edit' && !empty($errors['feedback'])) echo "<br><span class='error'>".$errors['feedback']."</span>"; ?>
	<?php endif; ?>
</div>
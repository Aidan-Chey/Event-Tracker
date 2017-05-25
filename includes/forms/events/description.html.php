<div class="form-element">
	<label for="field_description">Description: <?php requStar($form); ?></label>
	<?php if(empty($form)): ?>
	<p>form variable not specified.</p>
	<?php else: ?>
	<textarea <?php if($form=='view'){ echo "disabled"; }else{echo "placeholder='Manditory if Declined'";}?> name="description" rows="3" id="field_description" spellcheck="true" ><?php if(!empty($input['description'])){ htmlout($input['description']); } ?></textarea>
	<?php if($form=='edit' && !empty($errors['description'])) { echo "<br><span class='error'>".$errors['description']."</span>"; }?>
	<?php endif; ?>
</div>
<label for="<?php echo $id; ?>"><?php echo $label; ?></label>
<?php if(!empty($form)): if($form == 'edit'): ?>
<select name="<?php echo $name; ?>" id="<?php echo $id; ?>">
	<option hidden <?php if(empty($value) || !empty($errors['consider']["$key"])) echo "selected" ?> value='Null'>Select One</option>
	<option <?php if(!empty($value) && $value == 'Yes') echo "selected" ?>>Yes</option>
	<option <?php if(!empty($value) && $value == 'No') echo "selected" ?>>No</option>
</select>
<?php elseif($form == 'view'): ?>
<input disabled name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="<?php if(!empty($value) && $value != 'Null') htmlout($value); ?>">
<?php endif; endif; ?>

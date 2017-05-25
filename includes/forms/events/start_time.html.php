<div class="form-element">
	<label for="field_start_time">Start Time: <?php requStar($form); ?></label>
<?php if(!empty($form)): ?>
	<input
		name='start[time]'
		id='field_start_time'
		<?php if($form == 'edit'){ echo ' required onchange="calculateTime();"'; }
			elseif($form == 'view') echo ' disabled';
			if(!empty($input['start'])): ?>
				value="<?php time_out( $input['start'] ); ?>"
			<?php endif; ?>
	>
	<?php if(!empty($errors['start']['time'])) { echo "<br><span class='error'>".$errors['start']['time']."</span>"; }?>
<?php endif; ?>
</div>
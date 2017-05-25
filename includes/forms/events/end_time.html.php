<div class="form-element">
	<label for="field_end_time">End Time: <?php requStar($form); ?></label>
<?php if(!empty($form)): ?>
	<input
		name='end[time]'
		id='field_end_time'
		<?php if($form == 'edit'){ echo ' required onchange="calculateTime();"'; }
			elseif($form == 'view') echo ' disabled';
			if(!empty($input['end'])): ?>
				value="<?php time_out( $input['end'] ); ?>"
			<?php endif; ?>
	>
	<?php if(!empty($errors['end']['time'])) echo "<br><span class='error'>".$errors['end']['time']."</span>"?>
<?php endif; ?>
</div>
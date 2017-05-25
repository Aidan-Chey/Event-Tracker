<div class="form-element">
	<label for="field_end_date">End Date: <?php requStar($form); ?></label>
<?php if(!empty($form)): ?>
	<input
		name='end[date]'
		id='field_end_date'
		<?php if($form == 'edit'){ echo ' required onchange="calculateTime();"'; }
			elseif($form == 'view'){ echo ' disabled'; }
			if(!empty($input['end'])): ?>
				value="<?php date_out( $input['end'] ); ?>"
			<?php endif; ?>
	>
	<?php if(!empty($errors['end']['date'])) echo "<br><span class='error'>".$errors['end']['date']."</span>"?>
<?php endif; ?>
</div>
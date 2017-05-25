<div class="form-element">
	<label for="field_start_date">Start Date: <?php requStar($form); ?></label>
<?php if(!empty($form)): ?>
	<input
		name='start[date]'
		id='field_start_date'
		<?php if($form == 'edit'){ echo ' required onchange="calculateTime(); fillDate(this,document.getElementById(\'field_end_date\'));"'; }
			elseif($form == 'view') { echo ' disabled'; }
			if(!empty($input['start'])): ?>
				value="<?php date_out( $input['start'] ); ?>"
			<?php endif; ?>
	>
	<?php if(!empty($errors['start']['date'])) { echo "<br><span class='error'>".$errors['start']['date']."</span>"; }?>
<?php endif; ?>
</div>
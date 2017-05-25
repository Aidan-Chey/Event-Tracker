<script type="text/javascript">
	// auto submits calendar selection (info) form when called
	function submit() {
		document.getElementById('infoForm').submit();
	}
</script>
<form method="get" id="infoForm">
	<select required name="info" onchange="submit();" style="font-size:0.8em; background-color:hsla(0,0%,0%,0);">
		<option <?php if(!empty($_GET['info']) && $_GET['info'] == "Full Portfolio"){echo 'selected';} ?> value="Full_Portfolio">Full Portfolio</option>
		<?php foreach ($locations as $value): /*Adds stations to the dropdown*/ ?>
			<option <?php if($_GET['info'] == $value){echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
		<?php endforeach; ?>
	</select>
	<?php if(isset($_GET['axis'])): /*added to make sure submiting the form maintains the axis orientation of the monthly calendar*/ ?>
		<input style='display:none;' name='axis'>
	<?php endif; ?>
</form>

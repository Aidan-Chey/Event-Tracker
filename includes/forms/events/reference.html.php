<?php //HTML to display the form for the reference number of the event ?>
<div class="form-element">
	<label for="field_Id">Event ID:</label>
	<input disabled type="number" min="0" name="Id" id="field_Id" value="<?php if(!empty($input['id'])) htmlout($input['id']); ?>">
</div>
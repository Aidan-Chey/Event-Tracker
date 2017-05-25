<div class="form-element">
	<label for="details_Created">Created:</label>
	<input disabled name="created" id="details_Created" value="<?php if(!empty($input['created'])){ date_out( $input['created'] ); } if( !empty( $date ) ){ date_out( $date ); } ?>">
</div>
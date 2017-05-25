<?php if(!empty($form) && $form == 'view'){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/comments/getComments.inc.php';
	$comments = getComments($input['id']);
} ?>
<label for="field_comment">Comments:</label>
<?php if(!empty($form) && $form == 'view' && !(isset($_GET['archive']) && $_GET['archive'] == 'on')): ?>
	<label for="commentCheck" class="button" id="commentButton">Add Comment</label>
	<input id="commentCheck" type="checkbox" class="hide" checked name="addComment">
	<form method="post">
		<div class="textBox">
			<textarea rows="3" placeholder="New Comment Here (Max 500 Characters)" maxlength="500" name="content" onblur="this.value=this.value.toUpperCase();" style="text-transform:uppercase;"><?php if(!empty($input['content'])) htmlOut($input['content']); ?></textarea>
		</div>
		<input type="hidden" name="event_id" value="<?php echo $input['id']; ?>">
		<input type="hidden" name="listSelect" value="<?php echo $_POST['listSelect']; ?>">
		<input type="hidden" name="view">
		<input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
		<button name="addComment">Submit</button>
	</form>
<?php endif; ?>
	<textarea <?php if(!empty($form) && $form == 'view'){ echo "disabled"; }else{ echo " name='comment' ";} ?> rows="3" id="field_comment" spellcheck="true" onblur="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" <?php if(!empty($form) && $form=='edit'): ?>placeholder="New comment added to comments log for event; you won't be able to see previous comments in this view."<?php endif; ?>><?php if(!empty($input['comment'])) {htmlOut($input['comment'].'&#13;&#10;'.'&#13;&#10;');}
		if(!empty($form) && $form == 'view'){
			foreach($comments as $comment){
				htmlOut('On: '.$comment['created'].' | By: '.$comment['name'].'&#13;&#10;'.$comment['content'].'&#13;&#10;'.'&#13;&#10;');
			}} ?></textarea>
	<?php if(!empty($form) && $form == 'edit'){
	if(!empty($errors['comment'])) echo "<span class='error'>".$errors['comment']."</span>";
}?>
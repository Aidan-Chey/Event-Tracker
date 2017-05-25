<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

if(!userHasRole('admin')){
	header('Location: /?Permission');
	exit();
}
?>
<h2>Register Import</h2>
<section>
	<h3>Select XML to Upload</h3>
	<form method="post" enctype="multipart/form-data">
		<p>Drag and drop file in box</p>
		<p>
			<input type="file" accept=".xml" name="upload" droppable="true">
			<?php if(!empty($errors['upload'])){ echo "<br><span class='error'>".$errors['upload']."</span>"; }?>
		</p>
		<h3>Warning! Duplicate IDs/Refs will overwrite existing events.</h3>
		<p>
			<button>Submit</button>
			<?php if(!empty($_SESSION['messages'])): ?>
				<br><span class="error"><?php htmlout($_SESSION['messages']); ?></span>
			<?php endif; ?>
		</p>
	</form>
</section>

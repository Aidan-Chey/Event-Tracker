<?php //HTML to allow users to pick events to view ?>
<style type="text/css">
#Results form{
margin:auto;
}
#Results tbody td:nth-child(7){
max-width: none;
}

</style>
<section id="Results">
	<h3>Search Results for <span><?php echo ucwords($_POST['selection']); ?></span></h3>
	<form method="post" action="/Search/?#Form_Top">
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/status.php';
			$table = createTableData($lengthEvents);
			include $_SERVER['DOCUMENT_ROOT'].'/includes/forms/table.html.php'; ?>
		<p class="noPrint">
			<button name="view">View Event</button>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/copyElement.inc.php'; ?>
		<p>
	</form>
</section>
<h2 style="@media(print){whitespace:nowrap;}">Events Calendar - <?php include $_SERVER['DOCUMENT_ROOT'].'/Calendar/info.inc.php'; ?> - Monthly</h2>
<?php include $_SERVER['DOCUMENT_ROOT'].'/Calendar/key.inc.php'; ?>
<table id="calendar">
	<?php if(!isset($_GET['axis'])): ?>
	<thead>
		<tr>
			<th style="min-width: 7em">
				<a class="button" href="<?php echo $_SERVER['REQUEST_URI'].'&axis' ?>">Alt Axis</a>
			</th>
		<?php foreach($monthRows as $month => $o): ?><!--
			 --><th><?php echo date('M-y',strtotime($month)); ?></th>
		<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($calendarLocations as $location): ?>
		<tr>
			<th class="yHeaders" style="min-width: 7em"><?php echo $location; ?></th>
			<?php foreach ($monthRows as $month => $o): ?>
				<td>
				<?php include 'calendarCell.php'; ?>
				</td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php else: ?>
	<style type="text/css">
	#calendar td,#calendar th{
	min-width: 7.5em;
	}
	</style>
	<thead>
		<tr>
			<th style="min-width: 7em">
				<a class="button" href="<?php echo substr($_SERVER['REQUEST_URI'], 0, -5); ?>">Alt Axis</a>
			</th>
		<?php foreach($calendarLocations as $location): ?>
			<th><?php echo $location; ?></th>
		<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($monthRows as $month => $o): ?>
		<tr>
			<th class="yHeaders" style="min-width: 7em"><?php echo date('M-y',strtotime($month)); ?></th>
			<?php foreach ($calendarLocations as $location): ?>
				<td>
				<?php include 'calendarCell.php'; ?>
				</td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif; ?>
</table>

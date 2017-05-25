<h2>Events Calendar - Monthly</h2>
<?php include $_SERVER['DOCUMENT_ROOT'].'/Calendar/key.inc.php'; ?>
<table id="calendar">
	<tbody>
	<?php if(!isset($_GET['altAxis'])): ?> <!-- Normal Axis (Units on sides, dates on top/bottem) -->
		<tr>
			<th><a class="button" href="?altAxis">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		<?php foreach($months as $month): ?><!--
			 --><th><?php echo date('M-y',strtotime($month)); ?></th>
		<?php endforeach; ?><!--
			 --><th><a class="button" href="?altAxis">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		</tr>
		<?php foreach ($calendarLocations as $location): ?>
		<tr>
			<th><?php echo $location; ?></th>
		<?php foreach ($months as $month): ?><!--
			--><?php include 'calendarCell.php'; ?>
		<?php endforeach; ?><!--
			 --><th><?php echo $location; ?></th>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th><a class="button" href="?altAxis">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		<?php foreach($months as $month): ?><!--
			 --><th><?php echo date('M-y',strtotime($month)); ?></th>
		<?php endforeach; ?><!--
			 --><th><a class="button" href="?altAxis">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		</tr>
	<?php else: ?> <!-- Alternate Axis (Dates on sides, units on top/bottem) -->
		<tr>
			<th><a class="button" href="?">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		<?php foreach ($calendarLocations as $location): ?><!--
			 --><th><?php echo $location; ?></th>
		<?php endforeach; ?><!--
			 --><th><a class="button" href="?">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		</tr>
		<?php foreach($months as $month): ?>
		 <tr>
			<th><?php echo date('M-y',strtotime($month)); ?></th>
		<?php foreach ($calendarLocations as $location): ?><!--
			--><?php include 'calendarCell.php'; ?>
		<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th><a class="button" href="?">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		<?php foreach ($calendarLocations as $location): ?><!--
			 --><th><?php echo $location; ?></th>
		<?php endforeach; ?><!--
			 --><th><a class="button" href="?">Axis</a><a class='button' onclick="toggleFullScreen();">Full</a></th>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

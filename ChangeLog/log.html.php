<section id='changelog'>
	<?php if(!empty($log)): ?>
	<h2>Change Log</h2>
	<?php if(!empty($_SESSION['messages'])) echo "<br><span class='error'>".$_SESSION['messages']."</span>"; ?>
	<ul>
		<?php foreach($uniqueDays as $value): ?>
		<li>
			<?php echo $value; ?>
			<ul>
				<?php foreach ($log as $k => $v):
					if($v['date'] == $value): ?>
					<li><?php htmlout($v['change']); ?>
				<?php endif; endforeach ?>
			</ul>
		</li>
	<?php endforeach; ?>
	</ul>
<?php else: ?>
	<h3>No changes in the last 6 months</h3>
	<p><a class="button" href="/">Cancel</a></p>
	<?php if(!empty($_SESSION['messages'])) echo "<br><span class='error'>".$_SESSION['messages']."</span>"; ?>
<?php endif; ?>
</section>
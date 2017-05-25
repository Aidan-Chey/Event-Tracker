<section id="Transaction">
	<h3>Transaction</h3>
	<p>
		<span>
			<label for="field_id">ID: </label>
			<span id="field_id"><?php htmlOut($transaction['id']); ?></span>
		</span>
		<span>
			<label for="field_name">Name: </label>
			<span id="field_name"><?php htmlOut($transaction['name']); ?></span>
		</span>
		<span>
			<label for="field_ts">Timestamp: </label>
			<span id="field_ts"><?php dateTime_out($transaction['timestamp']); ?></span>
		</span>
		<span>
			<label for="field_item">Item: </label>
			<span id="field_item"><?php htmlOut(ucfirst($transaction['item'])); ?></span>
		</span>
		<span>
			<label for="field_action">Action: </label>
			<span id="field_action"><?php htmlOut($transaction['action']); ?></span>
		</span>
	</p>
	<div>
		<table id="compare">
			<thead>
				<tr>
					<?php foreach (array_keys($trans_table[0]) as $value): ?>
						<td><?php echo ucfirst($value); ?></td>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody><!--
			<?php foreach ($trans_table as $value): ?>
				 --><tr>
				<?php foreach ($value as $out): ?>
					<td><?php echo $out; ?></td>
				<?php endforeach ?>
				</tr><!--
			<?php endforeach; ?>
				 --><tr class="hiddenHead">
					<?php foreach (array_keys($trans_table[0]) as $value): ?>
						<td><?php echo ucfirst($value); ?></td>
					<?php endforeach; ?>
				</tr><!--
			 --></tbody>
		</table>

		<script type="text/javascript">
			function alignCompare(){
				var table = document.getElementById('compare');
				var columns = table.children[1].children[0].children;
				var heads = table.children[0].children[0].children;
				for (var i = heads.length - 1; i >= 0; i--) {
					heads[i].style.width = columns[i].offsetWidth+"px";
				};
			}
			var tableTimerC;
			setTimeout(function(){alignCompare();}, 10);
			window.onresize = function() {
				clearTimeout(tableTimerC);
				tableTimerC = setTimeout(function(){
					alignCompare();
				},50);
			}
			var mediaQueryListC = window.matchMedia('print');
			mediaQueryListC.addListener(function(mql) {
				if (mql.matches) {
					alignCompare();
				}else{
					alignCompare();
				}
			});
		</script>
	</div>
</section>
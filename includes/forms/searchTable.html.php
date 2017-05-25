<div style="text-align:center;">
	<table id="search_table" class="table search_table">
		<thead>
			<tr>
				<td>ID</td><!--
				 --><td>Type</td><!--
				 --><td>Status</td><!--
				 --><td>Requester</td><!--
				 --><td>Location</td><!--
				 --><td>Start date</td><!--
				 --><td>Finish date</td><!--
				 --><td>Description</td>
			</tr>
		</thead>
		<tbody>
			<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/status.php'; ?>
			<?php foreach ($events as $key => $value): ?>
				<input class="hiddenInput" type="radio" name="listSelect" id="input_<?php echo "$key"; ?>" value="<?php echo $value['id']; ?>">
				<tr id="record_<?php echo $key; ?>" onclick="optionSelect(this)" <?php if((isset($_GET['listSelect']) && $_GET['listSelect'] == $value['id'] ) || (isset($_POST['listSelect']) && $_POST['listSelect'] == $value['id'])) echo 'class="selectedRow"'; ?>>
					<td>
						<?php htmlOut($value['id']); ?>
						<?php if((isset($_GET['listSelect']) && $_GET['listSelect'] == $value['id'] ) || (isset($_POST['listSelect']) && $_POST['listSelect'] == $value['id'])): ?>
							<script type="text/javascript">document.getElementById("input_<?php echo $key; ?>").checked='true';</script>
						<?php endif; ?>
					</td>
					<td><?php htmlOut($value['type']); ?></td>
					<?php $status = status($value['stage'],array('placeholder'=>$value['placeholder']));
					echo '<td title="'.current($status).'">'.key($status).'</td>'; ?>
					<td><?php htmlOut($value['requester']); ?></td>
					<td><?php htmlOut($value['location']); ?></td>
					<td><?php echo date('Y-m-d',strtotime($value['start'])); ?></td>
					<td><?php echo date('Y-m-d',strtotime($value['end'])); ?></td>
					<td class="shorten"><?php htmlOut($value['description']); ?></td>
				</tr>
			<?php endforeach; ?>
				<tr class="hiddenHead">
					<td>ID</td>
					<td>Type</td>
					<td>Status</td>
					<td>Requester</td>
					<td>Location</td>
					<td>Start date</td>
					<td>Finish date</td>
					<td>Description</td>
				</tr>
		</tbody>
	</table>

	<script type="text/javascript">
		function optionSelect(row) {
			var tbodyRows = row.parentNode.rows;
			for (var i = tbodyRows.length - 1; i >= 0; i--) {
				var classes = tbodyRows[i].className.replace('selectedRow','');
				tbodyRows[i].className = '';
				if(classes != ''){
					tbodyRows[i].className = classes;
				}
			};
			row.className += ' selectedRow';
			document.getElementById("input_"+row.id.replace("record_",'')).checked = true;
		}
		function alignColumns() {
			var rows = document.getElementById('search_table').children[1].children;
			for (var i = rows.length - 1; i >= 0; i--) {
				rows[i].style.display = 'table-row-group';
			};
			setTimeout(function(){
				for (var i = rows.length - 1; i >= 0; i--) {
					if (rows[i].style.removeProperty) {
						rows[i].style.removeProperty('display');
					} else {
						rows[i].style.removeAttribute('display');
					}
				};
			}, 0);

		}

		function alignHeaders() {
			var table = document.getElementById('search_table');
			var columns = table.children[1].children[0].children;
			var heads = table.children[0].children[0].children;
			for (var i = heads.length - 1; i >= 0; i--) {
				heads[i].style.width = columns[i].offsetWidth+"px";
			};
		}
		var tableTimer;
		setTimeout(function(){alignHeaders();}, 10);
		window.onresize = function() {
			clearTimeout(tableTimer);
			if(window.matchMedia('(min-width: 840px)').matches){
				tableTimer = setTimeout(function(){
					alignColumns();
					alignHeaders();
				},50);
			}
		}
		var mediaQueryList = window.matchMedia('print');
		mediaQueryList.addListener(function(mql) {
			if (mql.matches) {
				alignHeaders();
			}else{
				alignHeaders();
			}
		});
	</script>
</div>
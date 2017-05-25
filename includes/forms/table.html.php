<div class="table">
	<table <?php if(!empty($table['id'])) echo "id='".$table['id']."'"; ?> <?php if(!empty($table['class'])) echo "class='".implode(' ',$table['class'])."'" ?>>
		<thead>
			<tr><?php foreach ($table['rows'][0] as $field => $data) echo "<td>".ucfirst($field)."</td>"; ?></tr>
		</thead>
		<tbody>
		<?php $selected = false;
			foreach ($table['rows'] as $num => $row):
				$id = $row['id'];
				$key = uniqid($id.'_',true);
				if( ( isset( $_GET['listSelect'] ) && $_GET['listSelect'] == $id )
					|| ( isset( $_POST['listSelect'] ) && $_POST['listSelect'] == $id )
					|| ( isset( $_GET['id'] ) && $_GET['id'] == $id )
				) $selected = "record_$key"; ?><!--
				--><input
					class="hiddenInput"
					type="radio"
					name="listSelect"
					id="input_<?php echo "$key"; ?>"
					value="<?php echo $id; ?>"
				><tr
					id="record_<?php echo $key; ?>"
					onclick="optionSelect(this)"
				><?php foreach ($row as $field => $data) echo "<td>$data</td>"; ?></tr><!--
			<?php endforeach ?>
			--><tr class="hiddenHead"><?php foreach ($table['rows'][0] as $field => $data) { echo "<td>$field</td>"; } ?></tr>
		</tbody>
	</table>
	<script type="text/javascript">
		//Reference to the table above this sctipt (first table in the parent div)
		var table= document.currentScript.parentNode.getElementsByTagName('TABLE')[0];

		//Makes nessesary changes when a body row is selected (clicked on)
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
		//Reflows the table columns when moving from mobile to desktop (bugs in Chrome)
		function alignColumns() {
			var rows = table.children[1].children;
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
		//Align Table Head with dummy headers at bottom of table body
		function alignHeaders() {
			var heads = table.children[0]/*head*/.children[0]/*first TR*/.children;
			var columns = table.children[1]/*body*/.children[0]/*first TR*/.children;
			for (var i = heads.length - 1; i >= 0; i--) {
				heads[i].style.width = columns[i].clientWidth+"px";
			};
		}
		alignHeaders();
		var tableTimer;
		window.onresize = function() {
			clearTimeout(tableTimer);
			if(window.matchMedia('(min-width: 840px)').matches){
				tableTimer = setTimeout(function(){
					alignColumns();
					alignHeaders();
				},10);
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
		<?php if($selected) echo "document.getElementById('$selected').click();"; ?>
	</script>
</div>
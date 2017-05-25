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

function alignHeaders(){
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
	tableTimer = setTimeout(function(){
		alignHeaders();
	},500);
}
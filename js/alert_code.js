<script type="text/javascript">
function outerHTML(node){
	//return object/node to string & return it
	var output = node.parentNode.parentNode.children;
	for (var i = 0; i < output.length; i++) {
		if(output[i].nodeName == 'DIV' && output[i].className == 'table') break;
	};
	output = output[i].children;
	console.log(output);
	for (var i = 0; i < output.length; i++) {
		console.log(output[i]);
		if(output[i].nodeName == 'TABLE') return output[i].outerHTML;
	};
}
function copy(button) {
	if(document.getElementById('copyMe')) {
		//Remove element
		var toRemove = document.getElementById('copyMe').parentNode;
		toRemove.parentNode.removeChild(toRemove);

		//Change button text
		button.innerHTML = 'Copy Table';
	}else{
		//Create elements to append to document containing code to be copied
		var newP = document.createElement("P");
		var newB = document.createElement("B");
		var newTextarea = document.createElement("TEXTAREA");
		var title = document.createTextNode("Copy Box | Copy to clipboard: Ctrl+C");
		var code = document.createTextNode(outerHTML(button));

		//combine elements to correct DOM tree
		newB.appendChild(title);
		newTextarea.appendChild(code);
		newTextarea.setAttribute('id','copyMe');
		newTextarea.setAttribute('style','display:block;width:100%;max-width:100%');
		newP.appendChild(newB);
		newP.appendChild(newTextarea);

		//Append element to document
		button.parentNode.insertBefore(newP, button);

		//Highlight the textbox text
		document.getElementById('copyMe').select();

		//Change button text
		button.innerHTML = 'Remove Copy Box';
	}
}
</script>
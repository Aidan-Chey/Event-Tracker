function formCollapse(input){
	var form = document.getElementById(input);
	var span = document.getElementById(input+'Span');
	if(form.checked){
		span.innerHTML =' ↑';
	}else{
		span.innerHTML =' ↓';
	}
}
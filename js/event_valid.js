function end(date){
	var parent = date.parentNode;
	var today = Date.now();
	var startField = Date.parse(document.getElementById('field_start_date').value);
	var finishField = Date.parse(date.value);
	var finishError = document.getElementById('finishDateError');
	var error = document.createElement('finish');
	error.className = "error";
	error.id = "finishDateError";
	error.style.whiteSpace = "normal";

	if(parent.contains(finish)){
		parent.removeChild(finish);
	}

	if(finishField <= today){
		error.innerHTML = "Please make sure finish date is after today.";
		parent.appendChild(error);
	}
	else if(finishField <= startField){
		error.innerHTML = "Please make sure finish date is after start date.";
		parent.appendChild(error);
	}
}
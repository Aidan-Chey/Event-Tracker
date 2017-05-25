function insertText(eElement,newElement,eLocation,text) {
	if(eElement){
		eElement.innerHTML = text;
	}else{
		newElement.innerHTML = text;
		eLocation.insertBefore(newElement,eLocation.firstChild);
	}
}

function invalidTiming(eElement,eLocation,text){
	var error = document.createElement('span');
	error.className = "error";
	error.id = "timingError";
	error.style.whiteSpace = "normal";

	insertText(eElement,error,eLocation,text);
}

function validateTiming(start,finish,oForm){
	var eLocation = document.getElementById('field_start_date').parentNode.parentNode;
	var eElement = document.getElementById('timingError');
	var today = Date.now();
	if(new Date(start) < (new Date(new Date().getTime()-(4*60*60*1000)/*4 hours*/))) {
		invalidTiming(eElement,eLocation,'Please make sure the start date & time is no later than 4 hours ago (allow time for approvals).')
	}else if(start >= finish) {
		invalidTiming(eElement,eLocation,'Please make sure the finish date & time is after the start date and time.');
	}else if(eElement) {
		eLocation.removeChild(eElement);
	}
}

function msToDHM(v) {
		var days = v / 8.64e7 | 0;
		var hrs = (v % 8.64e7)/ 3.6e6 | 0;
		var mins = Math.round((v % 3.6e6) / 6e4);

		return days + ' Days; ' + z(hrs) + ' Hours; ' + z(mins) + ' Minutes';

		function z(n){return (n<10?'0':'')+n;}
}
function calculateTime(){
	var scriptLocation = document.getElementById('eventTimeCalc');

	var start_date = document.getElementById('field_start_date').value;
	var start_time = document.getElementById('field_start_time').value;
	var end_date = document.getElementById('field_finish_date').value;
	var end_time = document.getElementById('field_finish_time').value;
	var isolation = document.getElementById('field_isolation').value*3600000;
	var deIsolation = document.getElementById('field_deIsolation').value*3600000;
	var recall = document.getElementById('field_recall').value*3600000;

	if(start_date && start_time){
		var start = Date.parse(start_date+'T'+start_time+'+13:00');
	}
	if(end_date && end_time){
		var end = Date.parse(end_date+'T'+end_time+'+13:00');
	}
	if(start && end){
		validateTiming(start,end);
		start -= isolation;
		end += deIsolation+recall;
		var text = "Total Event Duration: "+msToDHM(Math.abs(end - start));

		if(document.getElementById('eventTime')){
			document.getElementById('eventTime').innerHTML = text;
		}else{
			var element = document.createElement("DIV");
			var inner = document.createTextNode(text);

			element.id = 'eventTime';
			element.className = 'group';
			element.appendChild(inner);

			scriptLocation.parentNode.insertBefore(element,scriptLocation.previousSibling);
		}
	}
}

calculateTime();
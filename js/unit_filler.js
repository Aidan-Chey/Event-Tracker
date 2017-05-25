var Group = document.getElementById('field_group');
var Station = document.getElementById('field_station');
var Unit = document.getElementById('field_unit');

function station_fill(){
	switch(Group.value){
		case 'HLY':
			Station.innerHTML = "<option selected>Huntly</option>";
			break;
		case 'TRO':
			Station.innerHTML += "<option>Tokaanu</option>";
			Station.innerHTML += "<option>Rangipo</option>";
			break;
		case 'WKA':
			Station.innerHTML += "<option>Tuai</option>";
			Station.innerHTML += "<option>Piripaua</option>";
			Station.innerHTML += "<option>Kaitawa</option>";
			break;
		case 'TEK':
			Station.innerHTML = "<option selected>Tekapo</option>";
			break;
	}
}

function unit_fill(){
	if(Station.value == ""){
		Unit.innerHTML = "";
	}else{
		switch(Station.value){
			case 'Huntly':
				Unit.innerHTML += "<option>HLY</option>";
				Unit.innerHTML += "<option>HLY1</option>";
				Unit.innerHTML += "<option>HLY2</option>";
				Unit.innerHTML += "<option>HLY3</option>";
				Unit.innerHTML += "<option>HLY4</option>";
				Unit.innerHTML += "<option>HLY5</option>";
				Unit.innerHTML += "<option>HLY6</option>";
				Unit.innerHTML += "<option>HLY Common</option>";
				break;
			case 'Tokaanu':
				Unit.innerHTML += "<option>TKU</option>";
				Unit.innerHTML += "<option>TKU1</option>";
				Unit.innerHTML += "<option>TKU2</option>";
				Unit.innerHTML += "<option>TKU3</option>";
				Unit.innerHTML += "<option>TKU4</optio>";
				Unit.innerHTML += "<option>TKU Other</option>";
				break;
			case 'Rangipo':
				Unit.innerHTML += "<option>RPO</option>";
				Unit.innerHTML += "<option>RPO5</option>";
				Unit.innerHTML += "<option>RPO6</option>";
				Unit.innerHTML += "<option>RPO Other</option>";
				break;
			case 'Tuai':
				Unit.innerHTML += "<option>TUI</option>";
				Unit.innerHTML += "<option>TUI1</option>";
				Unit.innerHTML += "<option>TUI2</option>";
				Unit.innerHTML += "<option>TUI3</option>";
				Unit.innerHTML += "<option>TUI Other</option>";
				break;
			case 'Piripaua':
				Unit.innerHTML += "<option>PRI</option>";
				Unit.innerHTML += "<option>PRI4</option>";
				Unit.innerHTML += "<option>PRI5</option>";
				Unit.innerHTML += "<option>PRI Other</option>";
				break;
			case 'Kaitawa':
				Unit.innerHTML += "<option>KTW</option>";
				Unit.innerHTML += "<option>KTW6</option>";
				Unit.innerHTML += "<option>KTW7</option>";
				Unit.innerHTML += "<option>KTW Other</option>";
				break;
			case 'Tekapo':
				Unit.innerHTML += "<option>TEK</option>";
				Unit.innerHTML += "<option>TEK1</option>";
				Unit.innerHTML += "<option>TEK2</option>";
				Unit.innerHTML += "<option>TEK3</option>";
				Unit.innerHTML += "<option>TEK Other</option>";
				break;
		}
	}
}

function group_select(){
	switch(Group.value){
		case 'HLY':
			Unit.innerHTML = "";
			station_fill();
			station_select();
			break;
		case 'TRO':
			Station.innerHTML = "<option selected hidden value=''>Select One</option>";
			Unit.innerHTML = "";
			station_fill();
			break;
		case 'WKA':
			Station.innerHTML = "<option selected hidden value=''>Select One</option>";
			Unit.innerHTML = "";
			station_fill();
			break;
		case 'TEK':
			Unit.innerHTML = "";
			station_fill();
			station_select();
			break;
	}
	if(Station.value == ""){
		station_select();
	}
}

function station_select(){
	if(Station.value == ""){
		Unit.innerHTML = "";
	}else{
		Unit.innerHTML = "<option selected disabled hidden value=''>Select One</option>";
		unit_fill();
	}
}

if(Station.value == '' && Group.value != ''){
	group_select();
}else{
	if(Station.value != ''){
		station_fill();
	}
}
if(Unit.value == '' && Station.value != ''){
	station_select()
}else{
	if(Unit.value != ''){
		unit_fill();
	}
}
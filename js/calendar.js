function checkAll(inputname, checktoggle){
	var checkboxes = new Array();
	checkboxes = document.getElementsByName(inputname);

	for (var i=0; i<checkboxes.length; i++){
		if (checkboxes[i].type == 'checkbox'){
			checkboxes[i].checked = checktoggle;
		}
	}
}

function itemClick(item){
	if(item.checked==false){
		checkAll(item.name,true);
		item.checked=false;
	}
}

function toggleFullScreen() {
	if (!document.fullscreenElement // alternative standard method
		&&	!document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {	// current working methods
		if (document.documentElement.requestFullscreen) {
			document.documentElement.requestFullscreen();
		} else if (document.documentElement.msRequestFullscreen) {
			document.documentElement.msRequestFullscreen();
		} else if (document.documentElement.mozRequestFullScreen) {
			document.documentElement.mozRequestFullScreen();
		} else if (document.documentElement.webkitRequestFullscreen) {
			document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	} else {
		if (document.exitFullscreen) {
			document.exitFullscreen();
		} else if (document.msExitFullscreen) {
			document.msExitFullscreen();
		} else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	}
}
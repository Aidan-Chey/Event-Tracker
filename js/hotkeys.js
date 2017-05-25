document.onkeydown = function(e) {
	e = e || window.event; // because of Internet Explorer quirks...
	k = e.which || e.charCode || e.keyCode; // because of browser differences...

	if (k == 13 && e.altKey && e.ctrlKey && !e.shiftKey) { //Alt+Enter
		document.getElementById("submit").click();
	}else if (k == 83 && e.altKey && e.ctrlKey && !e.shiftKey) { //Alt+S
		document.getElementById("save").click();
	}else if (k == 27 && e.altKey && e.ctrlKey && !e.shiftKey) { //Alt+Escape
		document.getElementById("home").click();
	} else {
		return true; // it's not a key we recognize, move on...
	}
	return false; // we processed the event, stop now.
}
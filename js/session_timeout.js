var initialWait = 600000; //Miliseconds to wait before message appears
var confirmWait = 60; //Seconds to wait before user is logged out
var countdown;
var startInterval;
var startTimeout;
var blinker;
var original =document.title;
var countSpan = document.getElementById('count'); //Span containing coutdown timer in confirm box

var sessionReseter =  document.getElementById('sessionReseter'); //confirm box
var sessionOverlay = document.getElementById('sessionOverlay'); //Darkened Overlay

function logout(){
	if(document.getElementById('save')){
		document.getElementById('save').click();
	}else{
		window.location = "/?logout";
	}
}

function warning(){
	startInterval = setInterval(function(){
		if(countdown == 0){
			logout();
		}else{
			countdown -= 1;
			countSpan.innerHTML=countdown;
		}
	}, 1000);
	sessionReseter.setAttribute("style","display:block;");
	sessionOverlay.setAttribute("style","display:block;");
	window.focus();
	blinker=setInterval(function() {
		document.title='Logging Out';
		setTimeout(function(){document.title=original;}, 1000);
	},2000);
}

function reseter(){
	sessionReseter.setAttribute("style","display:none;");
	sessionOverlay.setAttribute("style","display:none;");
	clearInterval(startInterval);
	clearTimeout(startTimeout);
	clearInterval(blinker);
	countSpan.innerHTML=confirmWait;
}

function blinker(message,original) {
	setInterval(function() {
		document.title=message;
		setTimeout(function(){document.title=original;}, 1000);
	},2000);
}

function countDown(){ //resets all timers; defaults timer variables; starts timers
	reseter();
	countdown = confirmWait;
	startTimeout = setTimeout(warning, initialWait);
}

function stopInterval(){ //run on confirm box confirm button pressed
	countDown();
}

document.body.onload = function(){ //run on page load
	countDown();
}

document.body.onkeyup = function(){ //run on key up
	countDown();
}

document.body.onclick = function(){ //run on key down
	countDown();
}

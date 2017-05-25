var pass1 = document.getElementById('password');
var pass2 = document.getElementById('password2');
var errorContainer = document.getElementById('password').parentNode.innerHTML;
var name = document.getElementById('name');
var email = document.getElementById('email');
var nameTimer;
var emailTimer;
var passTimer;
var nameError = document.createElement("div");
nameError.id = "nameError";
var emailError = document.createElement("div");
emailError.id = "emailError";
var	passError = document.createElement("div");
passError.id = "passError";
var XHRresponse;

function nameValid(nameInput){
	clearTimeout(nameTimer);
	if(document.contains(document.getElementById('nameError'))){
		nameInput.parentNode.removeChild(nameError);
	}
	nameTimer = setTimeout(function(){
		var nameField = "name="+encodeURIComponent(nameInput.value);
		XHRresponse = "";
		Ajax("name.php",nameField);
		if(XHRresponse != ""){
			nameError.innerHTML = "<span class='error'>"+XHRresponse+"</span>";
			nameInput.parentNode.appendChild(nameError);
		}
	}, 1000);
}
function emailValid(emailInput){
	clearTimeout(emailTimer);
	if(document.contains(document.getElementById('emailError'))){
		emailInput.parentNode.removeChild(emailError);
	}
	emailTimer = setTimeout(function(){
		var emailField = "email="+encodeURIComponent(emailInput.value);
		XHRresponse = "";
		Ajax("email.php",emailField);
		if(XHRresponse != ""){
			emailError.innerHTML = "<span class='error'>"+XHRresponse+"</span>";
			emailInput.parentNode.appendChild(emailError);
		}
	}, 1000);
}
function confirmpass(confirm){
	clearTimeout(passTimer);
	if(document.contains(document.getElementById('passError'))){
		pass2.parentNode.removeChild(passError);
	}
	if(confirm != ""){
		passTimer = setTimeout(function(){action()}, 500);
	}else{
		action();
	}
}
function action(){
	if(pass1.validity.valid === true && pass2.validity.valid === true){
		if(pass1.value != pass2.value){
			if(!document.contains(document.getElementById('passError'))){
				pass2.parentNode.appendChild(passError);
			}
			document.getElementById('passError').innerHTML = "<span class='error'>Passwords do not match.</span>";
		}
	}
}

function Ajax(file,input){
	var XHR;
	if (window.XMLHttpRequest) {
		XHR=new XMLHttpRequest();
	} else {
		XHR=new ActiveXObject("Microsoft.XMLHTTP");
	}
	XHR.onreadystatechange=function() {
		if (XHR.readyState==4 && XHR.status==200) {
			if(XHR.responseText.length != 0){
				XHRresponse = decodeURIComponent(XHR.responseText.replace(/\+/g,' '));;
			}
		}
	}
	XHR.open("POST",file,false);
	XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XHR.send(input);
}
window.onload=init;

function init() {
	//this function associates the validator function with the form
	//it is used to maintain unobtrusive scripting
	document.getElementById("submitButton").onclick=validate;

}

function validate() {
	var valid = true;
	var firstName = document.forms["createUser"]["firstName"].value;
	if(firstName == null || firstName == "" ) {
		document.getElementById("firstNameError").innerHTML="First name required!";
  		valid= false;
  	} else document.getElementById("firstNameError").innerHTML="";

	var lastName = document.forms["createUser"]["lastName"].value;
	if(lastName == null || lastName == "" ) {
		document.getElementById("lastNameError").innerHTML="Last name required!";
  		valid= false;
  	} else document.getElementById("lastNameError").innerHTML="";

  	var email = document.forms["createUser"]["email"].value;
  	if(email == null || email == "" ) {
		document.getElementById("emailError").innerHTML="Email required!";
  		valid= false;
  	} else if(!validateEmail(email)) {
  		document.getElementById("emailError").innerHTML="Invalid email!";
  		valid= false;
  	} else document.getElementById("emailError").innerHTML="";

  	var password = document.forms["createUser"]["password"].value;
	if(password == null || password == "" ) {
		document.getElementById("passwordError").innerHTML="Password required!";
  		valid= false;
  	} else document.getElementById("passwordError").innerHTML="";
  	
  	var veriPassword = document.forms["createUser"]["veriPassword"].value;
	if(veriPassword == null || veriPassword == "" ) {
		document.getElementById("veriPasswordError").innerHTML="Password required!";
  		valid= false;
  	} else document.getElementById("veriPasswordError").innerHTML="";

  	if(!matchString(password, veriPassword)) {
  		document.getElementById("veriPasswordError").innerHTML="Password does not match!";
  		valid= false;
  	}else document.getElementById("veriPasswordError").innerHTML="";

	var avatar = document.forms["createUser"]["avatar"].value;
	if(avatar == null || avatar == "" ) {
		document.getElementById("avatarError").innerHTML="Please select an image.";
  		valid= false;
  	} else document.getElementById("avatarError").innerHTML="";

  	var age = document.forms["createUser"]["age"].value;
  	if(!validAge(age)) {
		document.getElementById("ageError").innerHTML="Please enter a valid age between 0 and 9001.";
  		valid= false;
  	} else document.getElementById("ageError").innerHTML="";

  	if(valid) {
  		document.forms["createUser"].submit();
  	}

}
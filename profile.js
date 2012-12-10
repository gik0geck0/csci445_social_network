window.onload=init;

function init() {
	//this function associates the validator function with the form
	//it is used to maintain unobtrusive scripting
	document.getElementById("submitButton").onclick=validate;

}

function validate() {
	var valid = true;
  	var email = document.forms["updateUser"]["email"].value;
  	if(email != null && email != "" ) {
      if(!validateEmail(email)) {
        document.getElementById("emailError").innerHTML="Invalid email!";
        valid= false;
      } else document.getElementById("emailError").innerHTML="";
  	}

  	var age = document.forms["updateUser"]["age"].value;
    if(age != null && age != "") {
  	  if(!validAge(age)) {
		    document.getElementById("ageError").innerHTML="Please enter a valid age between 0 and 9001.";
  		  valid= false;
  	  } else document.getElementById("ageError").innerHTML="";
    }

  	if(valid) {
  		document.forms["updateUser"].submit();
  	}

}
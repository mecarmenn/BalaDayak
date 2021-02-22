function validateForm() {
 
  var x = document.forms["myForm"]["username"].value;
     if (x == "") {
         alert("Username must be filled out");
     return false;
  }

   x = document.forms["myForm"]["Password"].value;
     if (x == "") {
         alert("password must be filled out");
     return false;
  }


}

function validateEnquiry() {
 
  var x = document.forms["myForm"]["Name"].value;
     if (x == "") {
         alert("Name must be filled out");
     return false;
  }

  x = document.forms["myForm"]["Email"].value;
     if (x == "") {
         alert("Email must be filled out");
     return false;
  }

  x = document.forms["myForm"]["Subject"].value;
     if (x == "") {
         alert("Subject must be filled out");
     return false;
  }

  x = document.forms["myForm"]["Content"].value;
     if (x == "") {
         alert("Content must be filled out");
     return false;
  }
}

function ConfirmClear()
{
  var answer = confirm("Are you sure you want to clear this form?")
  if (answer){
    alert("Form cleared")
    document.getElementById("myForm").reset();
  }
  else{
    alert("Form not cleared")
  }
}

function Show(){
  var reveal = document.getElementById("password");
  if (reveal.type === "password") {
    reveal.type = "text";
  } else {
    reveal.type = "password";
  }
}

function validateAddProduct(){
var x = document.forms["myForm"]["ProductName"].value;
if (x == "") {
    alert("Product Name must be filled out");
return false;
}

x = document.forms["myForm"]["ProductDesc"].value;
if (x == "") {
    alert("Product Name must be filled out");
return false;
}

x = document.forms["myForm"]["ProductPrice"].value;
if (x == "" || x == 0) {
    alert("Product Price must be filled out and cannot be zero");
return false;
}
}

function validateEditProduct(){
  
  var x = document.forms["myForm"]["ProductPrice"].value;
  if (x == 0) {
      alert("Product Price cannot be zero");
  return false;
  }
}
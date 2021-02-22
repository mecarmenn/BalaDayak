//to make sure only one is selected for gender
function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('Gender');
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false;
    });
}

function AlphabetFN(e, t){
     try {
          
            var isValid = false;
            var regex = /^[a-zA-Z\s]*$/;
            isValid = regex.test(document.getElementById("FullName").value);
            if (isValid == false){
                alert("Please type using letters only");
            }
            return isValid;
            }
            catch (err) {
                alert(err.Description);
            }
        }

function Alphabets(e, t){
     try {
          var charCode=0;
          if (window.event)
           {
                    charCode = window.event.keyCode;
                }
                else if (e) 
                {
                    charCode = e.key;
                }
                else
                { 
                    return true;

                 }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert("hello" + err.Description);
            }
        }

function Number(a){
    var charCode = (a.key) ? a.key : a.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }
    else {
        return true;
    }
}

function Show() {
  var reveal = document.getElementById("Password");
  if (reveal.type === "password") {
    reveal.type = "text";
  } else {
    reveal.type = "password";
  }
}

function ShowConfirm() {
  var reveal = document.getElementById("ConfirmPassword");
  if (reveal.type === "password") {
    reveal.type = "text";
  } else {
    reveal.type = "password";
  }

}


function ConfirmClear()
{
var answer = confirm("Are you sure you want to clear this form?");
if (answer){
alert("Form cleared");
document.getElementById("myForm").reset();
}
else{
    alert("Form not cleared");
}
}


function validate()
{


if( document.myForm.FullName.value == "" )
{
alert( "Please provide your full name!" );
document.myForm.FullName.focus() ;
return false;
}

if ( !isNaN(document.myForm.FullName.value))
{
alert ("There is a number in your name. Please write using characters only!");
document.myForm.FullName.focus();
return false;
}

if( document.myForm.PhoneNumber.value == "" )
{
alert( "Please provide your phone number!" );
document.myForm.FullName.focus() ;
return false;
}

if ( isNaN(document.myForm.PhoneNumber.value))
{
alert ("There is a character in your phone number! Please write using numerics only!");
document.myForm.PhoneNumber.focus();
return false;
}

if( document.myForm.Email.value == "" )
{
alert( "Please provide your Email!" );
document.myForm.Email.focus() ;
return false;
}


var a=document.myForm.Email.value;
var atpos=a.indexOf("@"); //to search for index of @
var dotpos=a.lastIndexOf("."); //to search for the last place '.' occurs
if(atpos<1 || dotpos<atpos+2 || dotpos+2>=a.length)
{
    alert("Please enter a valid email address containing '@'' and '.' ");
    return false;
}




var Password=document.myForm.Password.value;
var ConfirmPassword=document.myForm.ConfirmPassword.value;
var Requirements= /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/;


if( Password == "")
{
    alert( "Please provide a password!" );
    document.myForm.Password.focus() ;
    return false;
}

 if(!Requirements.test(Password)) 
{
    alert("Please provide a password that contains an uppercase letter, a lowercase letter, one numeric, one special character and no spaces, length must be more than 6.");
    return false;
}

if( ConfirmPassword == "")
{
    alert( "Please confirm your password!" );
    document.myForm.ConfirmPassword.focus() ;
    return false;
}

 if(!Requirements.test(ConfirmPassword)) 
{
    alert("Please provide a confirm password that contains an uppercase letter, a lowercase letter, one numeric, one special character and no spaces, length must be more than 6.");
    return false;
}

if (Password != ConfirmPassword) 
{ 
    alert ("The passwords do not match! Please retype passwords."); 
    return false; 
} 


if (document.myForm.Gender.value == "")
{
    alert("Please choose your gender!");
    return false;
}

if (document.myForm.Address.value == "")
{
    alert("Please enter an address!");
    return false;
}

var Terms = document.getElementByID("Terms").checked;

if(Terms == false)
{
    alert("Please accept terms and conditions!");
    return false;
}

alert( "Successfully registered!");
return( true );
}
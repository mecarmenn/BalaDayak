//http://form.guide/html-form/html-input-type-password.html
//https://bootsnipp.com/snippets/xp5N9

//to make sure only one is selected for gender
function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('Gender');
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false;
    });
}

function AlphabetFN(){
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

function Alphabets(e){
     try {
          var charCode=0;
          if (window.event)
           {
                    charCode = window.event.keyCode;
                }
                else if (e) 
                {
                    charCode = e.which;
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
    var charCode = (a.which) ? a.which : a.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }
    else{
        return true;
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

return true;
}
function ShowCurrent() {
    var reveal = document.getElementById("CurrentPassword");
    var image = document.getElementById("OpenEye1");
    if (reveal.type === "password") {
      reveal.type = "text";
      image.src ="ClosedEye.png";
    } else {
      reveal.type = "password";
      image.src ="OpenEye.png";
    }
  }
  
function ShowNew() {
    var reveal = document.getElementById("NewPassword1");
    var image = document.getElementById("OpenEye2");
    if (reveal.type === "password") {
      reveal.type = "text";
      image.src ="ClosedEye.png";
    } else {
      reveal.type = "password";
      image.src ="OpenEye.png";
    }
  }
  
  function ShowConfirmNew() {
    var reveal = document.getElementById("NewPassword2");
    var image = document.getElementById("OpenEye3");
    if (reveal.type === "password") {
      reveal.type = "text";
      image.src ="ClosedEye.png";
    } else {
      reveal.type = "password";
      image.src ="OpenEye.png";
    }
  
  }

function validatePassword(){
    var Password=document.getElementById("CurrentPassword").value;
    var NewPassword=document.getElementById("NewPassword1").value;
    var ConfirmNewPassword=document.getElementById("NewPassword2").value;
    var Requirements= /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/;
    
    
    if( Password == "")
    {
        alert( "Please provide your current password!");
        document.getElementById("CurrentPassword").focus();
        return false;
    }
    
    if( NewPassword == "")
    {
        alert( "Please provide your new password!" );
        document.getElementById("NewPassword1").focus();
        return false;
    }
    
     if(!Requirements.test(NewPassword)) 
    {
        alert("Please provide a password that contains an uppercase letter, a lowercase letter, one numeric, one special character and no spaces, length must be more than 6.");
        return false;
    }
    
    if( ConfirmNewPassword == "")
    {
        alert( "Please confirm your new password!" );
        document.getElementById("NewPassword2").focus();
        return false;
    }
    
     if(!Requirements.test(ConfirmNewPassword)) 
    {
        alert("Please provide a confirm password that contains an uppercase letter, a lowercase letter, one numeric, one special character and no spaces, length must be more than 6.");
        return false;
    }
    
    if (NewPassword != ConfirmNewPassword) 
    { 
        alert ("The new passwords do not match! Please retype passwords."); 
        return false; 
    } 
    return true;
}
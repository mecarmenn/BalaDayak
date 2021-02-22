<?php include('server.php') ?>


<!DOCTYPE html>
<html>
<head>
  <title>Sign Up Page</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
  <script src="registerForm.js" type="text/javascript"></script>
</head>
<body>
    <br><br>
    <table align="center" cellspacing="5" cellpadding="5" class="Buttons">
    <tr>
        <td>
            <div class="homeButton1">
                <?php echo "<a href=index.php>Home</a>" ?>
            </div>
        </td>
        <td>
            <div class="backButton">
                <?php echo "<a href=login.php>Back To Login Page</a>" ?>
            </div>
        </td>
    </tr>
    
    </table>
    <div class="header">
        <h2>Join Bala Dayak Boutique</h2>
    </div>
    
    <form id="myForm" name="myForm" onsubmit="return validate()"  method="post" action="register.php">
        <table align="center" cellspacing="5" cellpadding="5" border="solid">

        </table>
        <div class="input-group">
            <tr>
                <td><label>Full Name</label></td>
                <td><input type="text" name="FullName" id="FullName" onkeypress="return AlphabetFN(event,this);" ></td>
            </tr>
        </div>
        <div class="input-group">
            <tr>
                <td><label>Username</label></td>
                <td><input type="text" name="Username" id="Username" onkeypress="return Alphabets(event,this);" ></td>
            </tr>
        </div>
        <div class="input-group">
            <tr>
                <td><label>Phone Number</label></td>
                <td><input type="text" name="PhoneNumber" id="PhoneNumber" onkeypress="return Number (event);" ></td>
            </tr>
        </div>
        <div class="input-group">
            <tr>
                <td><label>Email</label></td>
                <td><input type="text" name="Email" id="Email" ></td>
            </tr>
        </div>
        <div class="input-group">
            <tr>
                <td><label>Password</label></td>
                <td><input type="password" name="Password" id="Password" > <button  class="Show" type="button" onclick="Show();"> <img src="OpenEye.png" class="OpenEye"></td>
            </tr>
        </div>
        <div class="input-group">
            <tr>
                <td><label>Confirm Password</label></td>
                <td><input type="password" name="ConfirmPassword" id="ConfirmPassword" > <button  class="Show" type="button" onclick="ShowConfirm();"> <img src="OpenEye.png" class="OpenEye"></td>
            </tr>
        </div>
        <div class="input-group">
            <tr>
                <td><label>Gender</label></td>
                <td>
                    <input type="radio" name="Gender" id="Gender" value="Female" onclick="onlyOne(this)" />Female
                    <input type="radio" name="Gender" id="Gender" value="Male" onclick="onlyOne(this)" />Male
                </td>
            </tr>
        </div>
        <div class="input-group">
            <tr>
                <td><label>Address</label></td>
                <td><input type="text" name="Address" id="Address" ></td>
            </tr>
        </div>
        </tr>
        <div class="input-group">
        <tr class="NoBorder">
            <td class="NoBorder"></td>
        </tr>
        </div>
        <div class="input-group">
        <tr class="ABox">
        <td class="ABox" colspan="2"> TERMS AND CONDITIONS </td>
        </tr>
        </div>
        <div class="input-group">
        <tr class="NoBorder">
        <td class="NoBorder" colspan="2"> <input type="checkbox" name="TAndC" id="TAndC" value="Accept" /> I accept the above Terms and Conditions</td></tr>
        </div>
        <div class="input-group">
        <td class="NoBorder" colspan="2" align="center">
            <input type="submit" name="registerUser" value="Register" /> 
            <input type="button" value="Clear" onclick="ConfirmClear()" ></td>
        </tr> 
        </div>
        </table>
    </form>
</body>
</html>
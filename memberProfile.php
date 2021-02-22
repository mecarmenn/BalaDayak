<?php
    session_start();
    include('header.php')
?>
<?php
    include('connect.php')
?>
<?php
    include('server.php')
?>
<?php
    if (!isset($_SESSION['username'])){
        $URL="index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
?>

<!DOCTYPE HTML>
<html>
        <head>
            <title>Your Profile</title>
            <link href='style.css' type='text/css' rel='stylesheet'/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="memberForm.js" type="text/javascript"></script>
            <script src="changePasswordJS.js" type="text/javascript"></script>
            <script>
                function confirmChange(){
                    if (confirm("Are you sure you want to change your password?")) {
                        var User = document.getElementById("UserID").value;
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("profile").innerHTML = this.responseText;
                        }
                        };
                        xmlhttp.open("GET", "changePassword.php?UserID=" + User , true);
                        xmlhttp.send();
                    }
                }
            </script>

        </head>
        
        <body>
            <h1>
                <center>
                    Your Profile, 
                    <?php echo
                    $_SESSION['username'];
                    ?>
                </center>
            </h1>
            <div class="profile" id="profile">
                <?php  
                    $stmt = mysqli_prepare($conn, "Select UserID, FullName, Username, PhoneNumber, Email, Gender, Address From Member Where Username = ?");
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $UserID, $FullName, $Username, $PhoneNumber, $Email, $Gender, $Address);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                ?>
                <br><br>
                <?php include('errors.php'); ?>
                <form id="myForm" name="myForm" method="post" onsubmit="return validate()" action="memberProfile.php">
                    <table align="center" cellspacing="5" cellpadding="5" class="memberProfile" border="solid">
                        <tr>
                            <td><label>Full Name</label></td>
                            <td><input type="text" name="FullName" id="FullName" onkeypress="return AlphabetFN();" value ="<?php echo $FullName ?>" ></td>
                        </tr>
                        <tr>
                            <td><label>Username</label><input type="hidden" name="UserID" id="UserID" value="<?php echo $UserID; ?>"></td>
                            <td><input type="text" name="Username" id="Username" onkeypress="return Alphabets(event);" value ="<?php echo $Username ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Phone Number</label></td>
                            <td><input type="text" name="PhoneNumber" id="PhoneNumber" onkeypress="return Number (event);" value ="<?php echo $PhoneNumber ?>"></td>
                        </tr>              
                        <tr>
                            <td><label>Email</label></td>
                            <td><input type="text" name="Email" id="Email" value ="<?php echo $Email ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Password</label></td>
                            <td><input type="button" name="Password" id="Password" value="Change Your Password" onclick="confirmChange()">
                        </tr>
                        <tr>
                            <td><label>Gender</label></td>
                            <?php if($Gender=="Female"){ ?>
                            <td>
                                <input type="radio" name="Gender" value="Female" onclick="onlyOne(this)" checked/>Female
                                <input type="radio" name="Gender" value="Male" onclick="onlyOne(this)" />Male
                            </td>
                            <?php } else if ($Gender == "Male"){?>
                                <input type="radio" name="Gender" value="Female" onclick="onlyOne(this)"/>Female
                                <input type="radio" name="Gender" value="Male" onclick="onlyOne(this)" checked/>Male
                            <?php } ?>                             
                        </tr>
                        <tr>
                            <td><label>Address</label></td>
                            <td><input type="text" name="Address" id="Address" value ="<?php echo $Address ?>"></td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <input type="submit" name="editProfile" value="Edit Profile">
                            </td>
                            
                        </tr>
                    </table>
                    <br><br>
                </form>
                <br>
            </div>
            
        </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
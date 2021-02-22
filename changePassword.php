<?php
    include('connect.php')
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" id="style" href="style.css">
        <script src="changePasswordJS.js" type="text/javascript"></script>
    </head>
    <body>
    <?php
        $UserID = intval($_GET['UserID']);
        
        $stmt = mysqli_prepare($conn, "Select Password From Member Where UserID = ?");
        mysqli_stmt_bind_param($stmt, "i", $UserID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $Password);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    ?>

    <form id="myForm" name="myForm" method="post" onsubmit="return validatePassword()" action="memberProfile.php">
        <table align="center" cellspacing="5" cellpadding="5" border="solid">
            <tr>
                <td><label>Current Password</label></td>
                <td><input type="password" name="CurrentPassword" id="CurrentPassword"><button  class="Show" type="button" onclick="ShowCurrent();"> <img src="OpenEye.png" id="OpenEye1" class="OpenEye"></td>
            </tr>
            <tr>
                <td><label>New Password</label><input type="hidden" name="UserID" value="<?php echo $UserID; ?>"></td>
                <td><input type="password" name="NewPassword1" id="NewPassword1"><button  class="Show" type="button" onclick="ShowNew();"> <img src="OpenEye.png" id="OpenEye2" class="OpenEye"></td>
            </tr>
            <tr>
                <td><label>Confirm New Password</label></td>
                <td><input type="password" name="NewPassword2" id="NewPassword2"><button  class="Show" type="button" onclick="ShowConfirmNew();"> <img src="OpenEye.png" id="OpenEye3" class="OpenEye"></td>
            </tr>                                      
            <tr>
                <td colspan=2>
                    <input type="submit" name="editPassword" value="Change Password">
                </td>          
            </tr>
        </table>
    </form>
    <?php
            mysqli_close($conn);
        ?>
    </body>
</html>
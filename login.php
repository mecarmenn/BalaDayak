<?php session_start()?>
<?php include('server.php') ?>


<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
  <script src="validateForm.js" type="text/javascript"></script>
</head>
<body>
    <br><br>
    <div class="homeButton2">
        <?php echo "<a href=index.php>Home</a>" ?>
    </div>
    <div class="header">
        <h2>Login to Bala Dayak Boutique</h2>
    </div>
  
    <form id="myForm" name="myForm" onsubmit="return validateForm ()"  method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{6}" title="Must contain at least ONE uppercase, ONE lowercase, ONE numeric, ONE special character, 6 digits and NO space allowed."> <button  class="Show" type="button" onclick="return Show()"> <img src="OpenEye.png" class="OpenEye"></button>
        </div>
        
        <div class="input-group">
            <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p>
            Not yet a member? Be part of us NOW! <a href="register.php">Sign up</a>
        </p>
        <p>
            BDB Admins <a href="loginAdmin.php">Sign in here</a>
        </p>
    </form>
</body>
</html>
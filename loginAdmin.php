<?php session_start(); ?>
<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login Page</title>
  <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body>
    <br><br>
    <div class="homeButton">
        <?php echo "<a href=index.php>Home</a>" ?>
    </div>
    <div class="header">
  	    <h2>Admin Login to Bala Dayak Boutique</h2>
    </div>

    <form method="post" action="loginAdmin.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="adminUserName" id="adminUserName">
        </div>
        
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="adminPassword" id="adminPassword">
        </div>
        
        <div class="input-group">
            <button type="submit" class="btn" name="login_admin">Login</button>
        </div>
    </form>
</body>
</html>
<?php
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
    }
?>

<!DOCTYPE HTML>
<html>
        <head>
            <link rel="stylesheet" id="style" href="style.css">
        </head>
        
        <body>
            <div class="navbar">
                <nav class="navigation" >
                    <ul class="navi" id="navi">
                        <?php if(isset($_SESSION['username'])) { ?>
                        <li class="dropdown">
                            Profile
                            <div class="content">
                                <a href="memberProfile.php">Update Profile</a>
                                <a href="logout.php">Log Out</a>
                            </div>
                        </li>
                        <?php } ?>
                        <li><?php echo 
                            "<a href=index.php>Home</a>"?></li>
                        <li><?php echo 
                            "<a href=product.php>Products</a>"?></li>
                        <li>
                            <?php if(isset($_SESSION['username'])) { ?>
                            <a href=cart.php>Cart</a> 
                            <?php } ?>
                        </li>
                        <li class="dropdown">
                            Boutique
                            <div class="content">
                                <a href="index.php#home-about">Bala Dayak Boutique</a>
                                <a href="index.php#home-contact">Reach Us</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            Founders
                            <div class="content">
                                <a href="65591/CarmenPortfolio.html">Carmen Soo</a>
                                <a href="65079/Miza.html">Hidayati Miza</a>
                                <a href="67864/My_resume.html">Syasya Syafiqah</a>
                                <a href="67255/resume_empty.html">Nur Zulaikha</a>
                            </div>
                        </li>
                        <li><a href=index.php#home-enquiry>Feedback</a></li>
                        <li style="float: right"><?php 
                            if (!isset($_SESSION['username'])){
                                echo "<a href=login.php>Login</a>";
                            } else if (isset($_SESSION['username'])){
                                echo "Hello ";
                                echo  $_SESSION['username']; 
                            }?>
                        </li>    
                    </ul>
                </nav>
                <br><br>
            </div>
            <script>
                window.onscroll = function() {myFunction()};
                
                var navitop = document.getElementById("navi");
        		var sticky = navitop.offsetTop;
        
        		function myFunction() {
          			if (window.pageYOffset >= sticky) {
                		navitop.classList.add("sticky")
              		} else {
                		navitop.classList.remove("sticky");
              		}
        		}
            </script>
        </body>
</html>
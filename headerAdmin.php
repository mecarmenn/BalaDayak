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
                <nav class="navigation">
                    <ul class="navi" id="navi">
                        <li class="dropdown">
                            <?php echo 
                            "<a href=dashboard.php>Dashboard</a>"?>
                            <div class="content">
                                <a href="logout.php">Log Out</a>
                            </div>
                        </li>
    
                        <li class="dropdown">
                            <?php echo 
                            "<a href=product.php>Products</a>"?>
                            <div class="content">
                                <a href="addProduct.php">Add Product</a>
                                <a href="editProduct.php">Edit Product</a>
                            </div>
                        </li>
                    
                        
                        <li>
                            <a href="order.php">Customer's Orders</a>
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
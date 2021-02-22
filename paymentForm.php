<?php 
    session_start();
    
    include('header.php');
?>
<?php
    include('connect.php')
?>
<?php
    if (!isset($_SESSION['username']) || empty($_GET['id'])){
        $URL="index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
?>

<!DOCTYPE HTML>
<html>
        <head>
            <title>Order</title>
            <link rel="stylesheet" id="style" href="style.css">
        </head>
        
        <body>
            <h3>
                <center>
                    Page to choose payment options, and how to receive your order, 
                    <?php echo
                    $_SESSION['username'];
                    ?>
                </center>
            </h3>
            <br>
            <br>
            <div class="viewOptions">
                <?php

                    $stmt = mysqli_prepare($conn, "Select TotalPrice From Orders Where OrderID = ?");
                    mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $TotalInsidePrice);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                ?>
                    <h3>
                        <center class="TotalPrice">
                            Total Price To Pay = <?php echo $TotalInsidePrice ?> <br><br>
                        </center>
                    </h3>
                    <form action="paymentForm.php?id=<?php echo $_GET['id'] ?>" method="post" name="myForm" id="myForm" value="myForm">
                    <div class="input-group">
                        <label>How would you like to pay?</label><br>

                        <input type="radio" name="PaymentOption" value="Cash Deposit Machine"/>Cash Deposit Machine
                        <input type="radio" name="PaymentOption" value="Cash"/>Cash
                        <input type="radio" name="PaymentOption" value="Bank Transfer" />Bank Transfer
                    </div>
                    <br>
                    <div class="input-group">
                        <label>How would you like to receive your product?</label><br>

                        <input type="radio" name="DeliveryOption" value="Pos Laju" />Pos Laju
                        <input type="radio" name="DeliveryOption" value="Self-Pickup" />Self-Pickup
                    </div>
                    <br>
                    <br>
                    <div class="submit-group">
                        <input type="submit" name="Options" value="Confirm"/>
                    </div>
                <?php
                    if(isset($_POST['Options'])){
                        $PaymentOption = $_POST['PaymentOption'];
                        $DeliveryOption = $_POST['DeliveryOption'];
                        $OrderID = $_GET['id'];
                        //Default 1 for PaymentStatusID and OrderStatusID as the code allows Pending Payment and cannot complete immediately and OrderStatus as None
                        $query = "UPDATE Orders SET DeliveryOption = '$DeliveryOption', PaymentOption = '$PaymentOption',PaymentStatusID = 1, OrderStatusID = 1 WHERE OrderID ='$OrderID'";
                        execute_query($query);
                        if(mysqli_affected_rows($conn)>0){
                            $stmt = mysqli_prepare($conn, "Select FullName, Email From Member Where Username = ?");
                            mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $FullName, $Email);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);

                            $OrderID = $_GET['id'];

                            $stmt = mysqli_prepare($conn, "Select FullName, Email From Member Where Username = ?");
                            mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $FullName, $Email);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);

                            $Subject = "OrderID of the Order is $OrderID. \n". 
                                        "By $FullName with email: $Email. \n".
                                        "Please take note of this new order in the order page";
                            $Content = $_POST['Content'];

                            function IsInjected($str)
                            {
                                $injections = array('(\n+)',
                                       '(\r+)',
                                       '(\t+)',
                                       '(%0A+)',
                                       '(%0D+)',
                                       '(%08+)',
                                       '(%09+)'
                                       );
                                           
                                $inject = join('|', $injections);
                                $inject = "/$inject/i";
                                
                                if(preg_match($inject,$str))
                                {
                                  return true;
                                }
                                else
                                {
                                  return false;
                                }
                            }
                            if(IsInjected($Email))
                            {
                                echo "Bad email value!";
                                exit;
                            }
                            $email_from = 'baladayakboutique01@gmail.com';

                            $email_subject = "New Order Received: $OrderID";
                        
                            $email_body = "You have received a new message from the user $Name.\n".
                                                    "Here is the message:\n $Subject. \n".
                                                    "$Content ";  
                            
                            $to = "baladayakboutique01@gmail.com";

                            $headers = "From: $email_from \r\n";

                            $headers .= "Reply-To: $Email \r\n";

                            mail($to,$email_subject,$email_body,$headers);
                            
                            
                            $URL="thankYou.php?id=".$OrderID;
                            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                        }

                        
                    }
                mysqli_close($conn);
                ?>
                </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
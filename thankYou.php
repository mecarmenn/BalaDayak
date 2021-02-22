<?php 
    session_start();
    
    include('header.php');
?>
<?php include('connect.php'); ?>
<?php
    
    $stmt = mysqli_prepare($conn, "Select UserID From Member Where Username = ?");
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $UserID1);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    $stmt = mysqli_prepare($conn, "Select UserID From Orders Where OrderID = ?");
    mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $UserID2);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    if (!isset($_SESSION['username']) || empty($_GET['id']) || $UserID1 != $UserID2){
        $URL="index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
?>

<!DOCTYPE HTML>
<html>
        <head>
            <title>Thank You</title>
            <link rel="stylesheet" id="style" href="style.css">
            <script>
                function printPageArea(areaID){
                var printContent = document.getElementById(areaID);
                var WinPrint = window.open('', '', 'width=3508,height=2480');
                WinPrint.document.write('<link rel="stylesheet" href="printStyle.css">');
                WinPrint.document.write(printContent.innerHTML);
                WinPrint.document.close();
                WinPrint.focus();
                WinPrint.print();
            }
            </script>
        </head>
        
        <body>
            <br> <br> <br>
            <h1>
                <center>
                    Thank you for ordering from us, 
                    <?php echo
                    $_SESSION['username'];
                    ?>
                </center>
            </h1>
            <br>
            <br>
            <div class="thankYou">
                    <h2>
                        <center>
                            If you have chosen Bank Transfer or Cash Deposit Machine as your payment method, here are our bank details:
                            <br>
                            <br>
                            Bank: RHB
                            <br>
                            <br>
                            Bank Account Number: 172849649279
                        </center>
                    </h2>
                    <h3>
                        <center class="TotalPrice">
                            We will be in touch for your order soon<br><br>
                        </center>
                    </h3>
                    <div id="GeneratedInvoice">
                        <center>
                            <img src="BDB.png" id="InvoiceLogo" alt="Bala Dayak Boutique" height="180" width="180">
                        </center>
                        <br>
                        <center class="Invoice">
                            Here's your invoice:<br><br>
                        </center>
                        <?php
                        
                        
                        $stmt = mysqli_prepare($conn, "Select m.UserID, m.FullName, m.PhoneNumber, m.Email, m.Address FROM Member m, Orders o WHERE m.UserID = o.UserID AND o.OrderID = ?;");
                        mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $UserID, $FullName, $PhoneNumber, $Email, $Address);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);

                        $stmt = mysqli_prepare($conn, "Select p.ProductName, s.SizeName, c.Quantity, p.Price From OrderContent c, Product p, Size s Where c.OrderID = ? AND c.ProductID = p.ProductID AND c.SizeID = s.SizeID");
                        mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);

                        $rowNum = mysqli_stmt_num_rows($stmt);
                        $orderInvoiceArray[$rowNum][4]=array();

                        if ($rowNum>0){
                            mysqli_stmt_bind_result($stmt, $ProductName, $SizeName, $Quantity, $Price);
                            //loop to retrieve the required fields from database and store in reusable variable
                            $i=0;
                            while(mysqli_stmt_fetch($stmt)){
                                $orderInvoiceArray[$i][0]=$ProductName;
                                $orderInvoiceArray[$i][1]=$SizeName;
                                $orderInvoiceArray[$i][2]=$Quantity;
                                $orderInvoiceArray[$i][3]=$Price;
                                $i++;
                            }
                        } else if ($rowNum == 0 || $rowNum==NULL){
                            echo "An Error has occured in generating your invoice";
                        }
                        mysqli_stmt_close($stmt);
                        ?>
                        <table align="center" cellspacing="5" cellpadding="5" border="solid" class="OrderInvoice">
                            <tr>
                                <td id="orderInvoiceTableTitle">ID</td>    
                                <td id="orderInvoiceTableTitle">Full Name</td>
                                <td id="orderInvoiceTableTitle">Phone Number</td>
                                <td id="orderInvoiceTableTitle">Email</td>
                                <td id="orderInvoiceTableTitle">Address</td>
                            </tr>
                            <tr>
                                <td><?php echo $UserID ?></td>
                                <td><?php echo $FullName ?></td>
                                <td><?php echo $PhoneNumber ?></td>
                                <td><?php echo $Email ?></td>
                                <td><?php echo $Address ?></td>
                            </tr>
                            <tr>
                                <td id="orderInvoiceTableTitle">No.</td>
                                <td id="orderInvoiceTableTitle">Product Name</td>
                                <td id="orderInvoiceTableTitle">Size</td>
                                <td id="orderInvoiceTableTitle">Quantity</td>
                                <td id="orderInvoiceTableTitle">Price (RM)</td>
                            </tr>
                        <?php 
                            for ($j=0;$j<$rowNum; $j++) {
                        ?>
                            <tr>
                                <td><?php $listNum = $j+1; echo $listNum; ?></td>
                                <td><?php echo $orderInvoiceArray[$j][0] ?></td> <!-- Product Name -->
                                <td><?php echo $orderInvoiceArray[$j][1] ?></td> <!-- Size -->
                                <td><?php echo $orderInvoiceArray[$j][2] ?></td> <!-- Quantity -->
                                <td>                                             <!-- Price -->
                                    <?php 
                                        $totalInsidePrice = (float)$orderInvoiceArray[$j][2] * $orderInvoiceArray[$j][3];
                                        echo $totalInsidePrice 
                                    ?>
                                </td> 
                            </tr>
                        <?php
                            }
                        ?>
                            <tr>
                                <td colspan= "3" align="right">Total Price (RM)</td>
                                <td colspan = "2">
                                    <?php 
                                        $stmt = mysqli_prepare($conn, "Select TotalPrice FROM Orders WHERE OrderID = ?;");
                                        mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $TotalPrice);
                                        mysqli_stmt_fetch($stmt);
                                        mysqli_stmt_close($stmt);
                                        
                                        echo $TotalPrice;
                                    ?>
                                </td>
                            </tr>
                        </table>
                        
                        <h1>
                            <center>
                                With Love From Bala Dayak Boutique <br>
                                
                                Have A Great Day
                            </center>
                        </h1>
                        <?php
                        mysqli_close($conn);
                        ?> 
                    </div>
                    <input type="button" id="printInvoice" value="Print Invoice" onclick="printPageArea('GeneratedInvoice')" />
            </div>
            </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
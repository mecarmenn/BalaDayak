<?php
    include('connect.php')
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" id="style" href="style.css">
    </head>
    <body>
        
            <?php                   
            $OrderID = intval($_GET['OrderID']);

            $stmt = mysqli_prepare($conn, "Select m.UserID, m.FullName, m.PhoneNumber, m.Email, m.Address FROM Member m, Orders o WHERE m.UserID = o.UserID AND o.OrderID = ?;");
            mysqli_stmt_bind_param($stmt, "i", $OrderID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowNum = mysqli_stmt_num_rows($stmt);
            if($rowNum>0){
                mysqli_stmt_bind_result($stmt, $UserID, $FullName, $PhoneNumber, $Email, $Address);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt); 
            } elseif ($rowNum == 0){
                mysqli_stmt_close($stmt);
                $Astmt = mysqli_prepare($conn, "Select m.ArchivedUserID, m.FullName, m.PhoneNumber, m.Email, m.Address FROM ArchivedMember m, Orders o WHERE m.ArchivedUserID = o.UserID AND o.OrderID = ?;");
                mysqli_stmt_bind_param($Astmt, "i", $OrderID);
                mysqli_stmt_execute($Astmt);
                mysqli_stmt_store_result($Astmt);
                $archivedRowNum = mysqli_stmt_num_rows($Astmt);
                if($archivedRowNum>0){
                    mysqli_stmt_bind_result($Astmt, $UserID, $FullName, $PhoneNumber, $Email, $Address);
                    mysqli_stmt_fetch($Astmt);
                    mysqli_stmt_close($Astmt); 
                } else{
                    $UserID = "User Details No Longer Exists";
                }
            }
            
            $stmt = mysqli_prepare($conn, "Select p.ProductName, s.SizeName, c.Quantity, p.Price From OrderContent c, Product p, Size s Where c.OrderID = ? AND c.ProductID = p.ProductID AND c.SizeID = s.SizeID");
            mysqli_stmt_bind_param($stmt, "i", $OrderID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $rowNum = mysqli_stmt_num_rows($stmt);
            $orderDetailArray[$rowNum][4]=array();

            if ($rowNum>0){
                mysqli_stmt_bind_result($stmt, $ProductName, $SizeName, $Quantity, $Price);
                //loop to retrieve the required fields from database and store in reusable variable
                $j=0;
                while(mysqli_stmt_fetch($stmt)){
                    $orderDetailArray[$j][0]=$ProductName;
                    $orderDetailArray[$j][1]=$SizeName;
                    $orderDetailArray[$j][2]=$Quantity;
                    $orderDetailArray[$j][3]=$Price;
                    $j++;
                }
            } else if ($rowNum == 0 || $rowNum==NULL){
                echo "An Error has occured in generating the order details";
            }
            mysqli_stmt_close($stmt);
        ?>
            
                    <table align="center" cellspacing="5" cellpadding="5" border="solid" class="OrderDetail">
                        <tr>
                            <td id="orderDetailTableTitle">ID</td>    
                            <td id="orderDetailTableTitle">Full Name</td>
                            <td id="orderDetailTableTitle">Phone Number</td>
                            <td id="orderDetailTableTitle">Email</td>
                            <td id="orderDetailTableTitle">Address</td>
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
                            <td><?php echo $orderDetailArray[$j][0] ?></td> <!-- Product Name -->
                            <td><?php echo $orderDetailArray[$j][1] ?></td> <!-- Size -->
                            <td><?php echo $orderDetailArray[$j][2] ?></td> <!-- Quantity -->
                            <td>                                             <!-- Price -->
                                <?php 
                                    $totalInsidePrice = (float)$orderDetailArray[$j][2] * $orderDetailArray[$j][3];
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
                                    mysqli_stmt_bind_param($stmt, "i", $OrderID);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_bind_result($stmt, $TotalPrice);
                                    mysqli_stmt_fetch($stmt);
                                    mysqli_stmt_close($stmt);
                                    
                                    echo $TotalPrice;
                                ?>
                            </td>
                        </tr>
                    </table>
            
            <script>
                alert("You have selected row with orderID <?php echo $OrderID ?>");
            </script>
        <?php
            mysqli_close($conn);
        ?>
    </body>
</html>
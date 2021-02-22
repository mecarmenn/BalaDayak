<?php 
    session_start();
    
    include('header.php');
?>
<?php
    include('connect.php')
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
            <title>Your Cart</title>
            <link rel="stylesheet" id="style" href="style.css">
        </head>
        
        <body>
            <h1>
                <center>
                    Happy shopping, 
                    <?php echo
                    $_SESSION['username'];
                    ?>
                </center>
            </h1>
            <br>
            <h2>
                <center>
                    Your shopping cart
                </center>
            </h2>
            <br>
            <div class="viewCart">
                <?php
                    $stmt = mysqli_prepare($conn, "Select UserID From Member Where Username = ?");
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $UserID);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);


                    $stmt = mysqli_prepare($conn, "Select p.ProductName, s.SizeName, c.Quantity, p.Price  From Cart c, Product p, Size s Where c.UserID = ? AND c.ProductID = p.ProductID AND c.SizeID = s.SizeID");
                    mysqli_stmt_bind_param($stmt, "i", $UserID);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    $rowNum = mysqli_stmt_num_rows($stmt);
                    $cartArray[$rowNum][4]=array();

                    if ($rowNum>0){
                        $empty = false;
                        mysqli_stmt_bind_result($stmt, $ProductName, $SizeName, $Quantity, $Price);
                        //loop to retrieve the required fields from database and store in reusable variable
                        $i=0;
                        while(mysqli_stmt_fetch($stmt)){
                            $cartArray[$i][0]=$ProductName;
                            $cartArray[$i][1]=$SizeName;
                            $cartArray[$i][2]=$Quantity;
                            $cartArray[$i][3]=$Price;
                            $i++;
                        }
                    } else if ($rowNum == 0 || $rowNum==NULL){
                        $empty = true;
                    }
                    mysqli_stmt_close($stmt);

                    if ($empty == false) {
                        
                        ?>
                
                <form action="cart.php" method="post" name="myForm" id="myForm" value="myForm">
                    <table align="center" cellspacing="10" cellpadding="10" border="solid" id="cartTable">
                        <?php 
                            (float)$totalPrice = 0.00;
                            for($j=0;$j<$rowNum; $j++){ 
                        ?>
                        <tr>
                            <td rowspan="4">
                               <?php 
                                $listNum = $j + 1;
                                echo $listNum; 
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td align="right" >Product Name</td>
                            <td colspan="3">
                                <label><?php echo $cartArray[$j][0]; ?></label>
                            </td>
                        </tr>
                        <tr>    
                            <td align="right">Product Size</td>
                            <td>
                                <select name="ProductSize" id="ProductSize">
                                        <?php
                                            $query = "Select SizeName From Size Limit 6";
                                            $result = mysqli_query($conn, $query);

                                            $sizeRowNum = mysqli_num_rows($result);
                                            $sizeArray[$sizeRowNum]=array();
                                            $i=0;
                                            while($row = mysqli_fetch_array($result)){
                                                $sizeArray[$i]=$row['SizeName'];
                                                if($row['SizeName']==$cartArray[$j][1]){
                                        ?>
                                                    <option value="<?php echo $row['SizeName'] ?>" selected><?php echo $row['SizeName'] ?></option>          
                                                    <?php 
                                                } else {
                                                    ?>
                                                <option value="<?php echo $row['SizeName'] ?>"><?php echo $row['SizeName'] ?></option>          
                                        <?php
                                                }
                                                $i++;
                                            }
                                        ?>
                                </select>
                            </td>
                            <td align="right">Quantity</td>
                            <td>
                                <input type="number" name="Quantity" id="Quantity" value=<?php echo $cartArray[$j][2]; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Price (RM)</td>
                            <td>
                                <label>
                                    <?php 
                                        $totalInsidePrice = (float)$cartArray[$j][2] * $cartArray[$j][3];
                                        $totalPrice = $totalPrice + $totalInsidePrice;
                                        echo $totalInsidePrice;
                                    ?>
                                </label>
                            </td>
                            <td colspan="2">
                                <input type="submit" value="Delete" name="delete" />
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td align="right" colspan="3">Total Price (RM)</td>
                            <td colspan="2">
                                <label >
                                    <input type="hidden" name="TotalPrice" value="<?php echo floatval($totalInsidePrice); ?>">
                                    <?php 
                                        echo floatval($totalInsidePrice); 
                                    ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="center">
                                <input type="submit" value="Edit" name="edit" />
                                <input type="submit" value="Proceed To Payment" name="proceedPayment" /> 
                            </td>
                        </tr> 
                    </table>
                </form>
            <?php
                if (isset($_POST['edit'])) {
                    $Size = $_POST['ProductSize'];//string
                    $Quantity = $_POST['Quantity']; //int
                
                    $stmt = mysqli_prepare($conn, "Select SizeID From Size Where SizeName = ?");
                    mysqli_stmt_bind_param($stmt, "s", $Size);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $SizeID);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                    
                    $stmt = mysqli_prepare($conn, "Select UserID From Member Where Username = ?");
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $UserID);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                
                    $stmt = mysqli_prepare($conn, "Update Cart Set SizeID = ? , Quantity = ? Where UserID = ?");
                    mysqli_stmt_bind_param($stmt, "iii", $SizeID, $Quantity, $UserID);
                    mysqli_stmt_execute($stmt);
                    echo "<meta http-equiv='refresh' content='0'>";
                    mysqli_stmt_close($stmt);
                }
                    else if (isset($_POST['delete'])){
                        $Size = $_POST['ProductSize'];//string
                        $Quantity = $_POST['Quantity']; //int
                    
                        $stmt = mysqli_prepare($conn, "Select SizeID From Size Where SizeName = ?");
                        mysqli_stmt_bind_param($stmt, "s", $Size);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $SizeID);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                        
                        $stmt = mysqli_prepare($conn, "Select UserID From Member Where Username = ?");
                        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $UserID);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                    
                        $stmt = mysqli_prepare($conn, "Delete From Cart Where SizeID = ? AND Quantity = ? AND UserID = ?");
                        mysqli_stmt_bind_param($stmt, "iii", $SizeID, $Quantity, $UserID);
                        mysqli_stmt_execute($stmt);
                        echo "<meta http-equiv='refresh' content='0'>";
                        mysqli_stmt_close($stmt);
                    } else if (isset($_POST['proceedPayment'])){
                        $TotalPrice = $_POST['TotalPrice'];
                        
                        $stmt = mysqli_prepare($conn, "Select UserID From Member Where Username = ?");
                        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $UserID);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);

                        $query = "INSERT INTO Orders (UserID,TotalPrice) VALUES('$UserID','$TotalPrice')";
                        execute_query($query);

                        $stmt = mysqli_prepare($conn, "Select OrderID From Orders Where UserID = ?");
                        mysqli_stmt_bind_param($stmt, "s", $UserID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $OrderID);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);

                        $stmt = mysqli_prepare($conn, "Select c.ItemID,p.ProductID, s.SizeID, c.Quantity  From Cart c, Product p, Size s Where c.UserID = ? AND c.ProductID = p.ProductID AND c.SizeID = s.SizeID");
                        mysqli_stmt_bind_param($stmt, "i", $UserID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);

                        $rowNum = mysqli_stmt_num_rows($stmt);

                
                        mysqli_stmt_bind_result($stmt, $ItemID, $ProductID, $SizeID, $Quantity);
                        //loop to retrieve the required fields from database and insert into OrderContent table
                        while(mysqli_stmt_fetch($stmt)){
                            $query = "INSERT INTO OrderContent(OrderID,ProductID,SizeID,Quantity) VALUES('$OrderID','$ProductID','$SizeID','$Quantity')";
                            execute_query($query);
                            if(mysqli_affected_rows($conn)>0){
                                $query = "DELETE FROM Cart WHERE UserID ='$UserID'";
                                execute_query($query);
                            }
                            
                        }
                        
                        mysqli_stmt_close($stmt);
                        
                          

                        $URL="paymentForm.php?id=".$OrderID;
                        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                    }
                }
                
                     else if ($empty == true) {
                ?>
                        <table align="center" cellspacing="10" cellpadding="10" border="solid">
                        
                        <tr>
                            <?php echo "You currently do not have anything in your cart" ?>
                        </tr>
                        <tr>    
                            <td align="right"></td>
                            <td>
                                
                            </td>
                            <td align="right"></td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"></td>
                            <td colspan="2">
                                
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="right" colspan="2">Total Price (RM)</td>
                            <td colspan="2">
                                <label>
                                    
                                </label>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>
                <?php
                    mysqli_close($conn);
                ?>
            </div>
        </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
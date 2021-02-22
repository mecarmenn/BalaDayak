<?php 
    session_start();
    if(isset($_SESSION['AdminUserName'])){
        
        include_once('headerAdmin.php');
    }
    else{
        $URL="index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
?>
<?php
    include('connect.php')
?>

<!DOCTYPE HTML>
<html>
        <head>
            <title>Customer's Order</title>
            <link rel="stylesheet" id="style" href="style.css">
            <script>
                function on() {
                    document.getElementById("overlay").style.display = "block";
                }

                function off() {
                    document.getElementById("overlay").style.display = "none";
                    document.getElementById("text").innerHTML = "";
                }
                function view(str) {
                    button = document.getElementById(str);
                    
                    if (button.value == "Show Completed Orders"){
                        document.getElementById("CompletedOrder").style.display = "none";
                        document.getElementById("HideCompletedOrder").style.display = "inline";
                    } else if (button.value == "Hide Completed Orders"){
                        document.getElementById("CompletedOrder").style.display = "inline";
                        document.getElementById("HideCompletedOrder").style.display = "none";
                        document.getElementById("responseText").innerHTML = "";
                    }
                }
            </script>
            <script src="orderJS.js"></script>
            <script src="completedOrdersJS.js"></script>  
        </head>
        
        <body>
            <h1>
                <center>
                    Welcome <?php echo  $_SESSION['AdminUserName']; ?>
                </center>
            </h1>
            <br>
            <h3>
                <center>
                    Here are the customers' orders for Bala Dayak Boutique
                </center>
            </h3>

            <div class="headerOrder">
                <br>
            
                <input type="button" id="CompletedOrder" value="Show Completed Orders" name="CompletedOrder" onclick="showCompletedOrders(); view(this.id);"/>
                <input type="button" id="HideCompletedOrder" value="Hide Completed Orders" name="HideCompletedOrder" onclick="view(this.id);"/>
            
                <br><br>
                <?php   
                    $query = "Select * From Orders Where OrderStatusID = 1 OR OrderStatusID = 2";
                    $result = mysqli_query($conn, $query);

                    $orderRowNum = mysqli_num_rows($result);
                    $orderArray[$orderRowNum][7]=array();
                    $i=0;
                    while($row = mysqli_fetch_array($result)){
                        $orderArray[$i][0]=$row['OrderID'];
                            
                        $stmt = mysqli_prepare($conn, "Select Username From Member Where UserID = ?");
                        mysqli_stmt_bind_param($stmt, "i", $row['UserID']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        $rowNum = mysqli_stmt_num_rows($stmt);
                        if($rowNum>0){
                            mysqli_stmt_bind_result($stmt, $orderArray[$i][1]);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                        } elseif ($rowNum == 0){
                            mysqli_stmt_close($stmt);
                            $stmt = mysqli_prepare($conn, "Select Username From ArchivedMember Where ArchivedUserID = ?");
                            mysqli_stmt_bind_param($stmt, "i", $row['UserID']);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            $archivedRowNum = mysqli_stmt_num_rows($stmt);
                            if($archivedRowNum>0){
                                mysqli_stmt_bind_result($stmt, $orderArray[$i][1]);
                                mysqli_stmt_fetch($stmt);
                                mysqli_stmt_close($stmt); 
                        } else{
                                $orderArray[$i][1]="No Longer Exist";
                            }
                        }
                            
                            
                        $orderArray[$i][2]=$row['TotalPrice'];
                        $orderArray[$i][3]=$row['DeliveryOption'];
                        $orderArray[$i][4]=$row['PaymentOption'];

                        $stmt = mysqli_prepare($conn, "Select PaymentStatusDetails From PaymentStatus Where PaymentStatusID = ?");
                        mysqli_stmt_bind_param($stmt, "i", $row['PaymentStatusID']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $orderArray[$i][5]);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);

                        $stmt = mysqli_prepare($conn, "Select OrderStatusDetails From OrderStatus Where OrderStatusID = ?");
                        mysqli_stmt_bind_param($stmt, "i", $row['OrderStatusID']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $orderArray[$i][6]);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);

                        $i++;
                    }  
                ?>
                
                <table align="center" cellspacing="5" cellpadding="5" class="Order">        
                        <tr>
                            <td>OrderID</td><td>Customer</td><td>Total Price</td><td>Delivery Option</td><td>Payment Option</td><td>Payment Status</td><td>Order Status</td><td>Action</td>
                        </tr>
                     
                        <?php
                    for ($j=0;$j<$orderRowNum; $j++) {
                            ?>
                    <form name="myForm" id="myForm" value="myForm">
                    <tr>
                        <td><?php echo $orderArray[$j][0] ?></td> <!-- OrderID -->
                        <td><?php echo $orderArray[$j][1] ?></td>
                        <td><?php echo $orderArray[$j][2] ?></td> <!-- Total Price -->
                        <td><?php echo $orderArray[$j][3] ?></td> <!-- Delivery Option -->
                        <td><?php echo $orderArray[$j][4] ?></td> <!-- Payment Option -->
                        <td>
                            <select name="PaymentStatusList" id="PaymentStatusList" class="PaymentStatusList"> <!-- PaymentStatus -->
                                <?php
                                    $query = "Select PaymentStatusDetails From PaymentStatus";
                                    $result = mysqli_query($conn, $query);

                                    $paymentStatusRowNum = mysqli_num_rows($result);
                                    $paymentStatusArray[$paymentStatusRowNum]=array();
                                    $k=0;
                                    while($row = mysqli_fetch_array($result)){
                                        $paymentStatusArray[$k]=$row['PaymentStatusDetails'];
                                        if($row['PaymentStatusDetails']==$orderArray[$j][5]){
                                ?>
                                        <option value="<?php echo $row['PaymentStatusDetails'] ?>" selected><?php echo $row['PaymentStatusDetails'] ?></option>          
                                    <?php 
                                        } else {
                                    ?>
                                        <option value="<?php echo $row['PaymentStatusDetails'] ?>"><?php echo $row['PaymentStatusDetails'] ?></option>          
                                    <?php
                                        }
                                        $k++;
                                        }
                                    ?>
                            </select>
                        </td>
                        <td><!-- OrderStatus -->
                            <select name="OrderStatusList" id="OrderStatusList" class="OrderStatusList">
                                <?php
                                    $query = "Select OrderStatusDetails From OrderStatus";
                                    $result = mysqli_query($conn, $query);

                                    $orderStatusRowNum = mysqli_num_rows($result);
                                    $orderStatusArray[$orderStatusRowNum]=array();
                                    $l=0;
                                    while($row = mysqli_fetch_array($result)){
                                        $orderStatusArray[$l]=$row['OrderStatusDetails'];
                                        if($row['OrderStatusDetails']==$orderArray[$j][6]){
                                ?>
                                        <option value="<?php echo $row['OrderStatusDetails'] ?>" selected><?php echo $row['OrderStatusDetails'] ?></option>          
                                    <?php 
                                        } else {
                                    ?>
                                        <option value="<?php echo $row['OrderStatusDetails'] ?>"><?php echo $row['OrderStatusDetails'] ?></option>          
                                    <?php
                                        }
                                        $l++;
                                        }
                                    ?>
                            </select>
                        </td> 
                        <td>
                            <input class="OrderID" id='OrderID[<?php echo $j+0?>]' type='hidden' value='<?php echo $orderArray[$j][0]?>'/>
                            <input type="button" id="OrderDetails[<?php echo $j?>]" value="Order Details" name="OrderDetails" onclick="show(this.id);on()"/>
                            <br><br>
                            <input type="button" id="OrderUpdate[<?php echo $j?>]" value="Update Order" name="OrderUpdate" onclick="update(this.id)"/>
                        </td>
                    </tr>
                    </form>
                    <?php
                        }
                    ?>
                </table>
                <br><br>
                <div id="responseText">
                
                </div>
                <div id="overlay" onclick="off()">
                    <div id="text">

                    </div>
                </div>   
                    
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
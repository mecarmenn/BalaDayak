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
            $query = "Select * From Orders Where OrderStatusID = 3";
            $result = mysqli_query($conn, $query);

            $orderCompleteRowNum = mysqli_num_rows($result);
            $orderCompleteArray[$orderCompleteRowNum][7]=array();
            $i=0;
            while($row = mysqli_fetch_array($result)){
            $orderCompleteArray[$i][0]=$row['OrderID'];
                                    
            $stmt = mysqli_prepare($conn, "Select Username From Member Where UserID = ?");
            mysqli_stmt_bind_param($stmt, "i", $row['UserID']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowNum = mysqli_stmt_num_rows($stmt);
            if($rowNum>0){
                mysqli_stmt_bind_result($stmt, $orderCompleteArray[$i][1]);
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
                    mysqli_stmt_bind_result($stmt, $orderCompleteArray[$i][1]);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt); 
                } else{
                    $orderCompleteArray[$i][1]="No Longer Exist";
                    }
                }
                                    
                                    
                $orderCompleteArray[$i][2]=$row['TotalPrice'];
                $orderCompleteArray[$i][3]=$row['DeliveryOption'];
                $orderCompleteArray[$i][4]=$row['PaymentOption'];

                $stmt = mysqli_prepare($conn, "Select PaymentStatusDetails From PaymentStatus Where PaymentStatusID = ?");
                mysqli_stmt_bind_param($stmt, "i", $row['PaymentStatusID']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $orderCompleteArray[$i][5]);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                $stmt = mysqli_prepare($conn, "Select OrderStatusDetails From OrderStatus Where OrderStatusID = ?");
                mysqli_stmt_bind_param($stmt, "i", $row['OrderStatusID']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $orderCompleteArray[$i][6]);
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
                        for ($j=0;$j<$orderCompleteRowNum; $j++) {
                    ?>
                        <form name="myForm" id="myForm" value="myForm">
                            <tr>
                                <td><?php echo $orderCompleteArray[$j][0] ?></td> <!-- OrderID -->
                                <td><?php echo $orderCompleteArray[$j][1] ?></td>
                                <td><?php echo $orderCompleteArray[$j][2] ?></td> <!-- Total Price -->
                                <td><?php echo $orderCompleteArray[$j][3] ?></td> <!-- Delivery Option -->
                                <td><?php echo $orderCompleteArray[$j][4] ?></td> <!-- Payment Option -->
                                <td>
                                    <select name="PaymentStatusListC" id="PaymentStatusListC" class="PaymentStatusListC"> <!-- PaymentStatus -->
                                        <?php
                                            $query = "Select PaymentStatusDetails From PaymentStatus";
                                            $result = mysqli_query($conn, $query);

                                            $paymentStatusRowNum = mysqli_num_rows($result);
                                            $paymentStatusArray[$paymentStatusRowNum]=array();
                                            $k=0;
                                            while($row = mysqli_fetch_array($result)){
                                                $paymentStatusArray[$k]=$row['PaymentStatusDetails'];
                                                if($row['PaymentStatusDetails']==$orderCompleteArray[$j][5]){
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
                                    <select name="OrderStatusListC" id="OrderStatusListC" class="OrderStatusListC">
                                        <?php
                                            $query = "Select OrderStatusDetails From OrderStatus";
                                            $result = mysqli_query($conn, $query);

                                            $orderStatusRowNum = mysqli_num_rows($result);
                                            $orderStatusArray[$orderStatusRowNum]=array();
                                            $l=0;
                                            while($row = mysqli_fetch_array($result)){
                                                $orderStatusArray[$l]=$row['OrderStatusDetails'];
                                                if($row['OrderStatusDetails']==$orderCompleteArray[$j][6]){
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
                                    <input class="OrderIDC" id='OrderIDC[<?php echo $j+0?>]' type='hidden' value='<?php echo $orderCompleteArray[$j][0]?>'/>
                                    <input type="button" id="OrderDetails[<?php echo $j?>]" value="Order Details" name="OrderDetails" onclick="showC(this.id);on()"/>
                                    <br><br>
                                    <input type="button" id="OrderUpdate[<?php echo $j?>]" value="Update Order" name="OrderUpdate" onclick="updateC(this.id)"/>
                                </td>
                            </tr>
                        </form>
                        <?php
                            }
                        ?>
                </table>               
                <?php
                    mysqli_close($conn);
                ?>
        </body>
    </html>
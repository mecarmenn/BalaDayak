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
            //Sum Total Sales, Sum Status "Completed" Orders, Sum Status "Ongoing" Orders, Sum Status "None" Orders in Order Table
            $TotalSales = 0;
            $Completed = 0;
            $Ongoing = 0;
            $None = 0;

            $query = "Select * From Orders";
            $result = mysqli_query($conn, $query);

            $orderRowNum = mysqli_num_rows($result);
            $orderArray[$orderRowNum][5]=array();
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
                $TotalSales += $orderArray[$i][2];

                $stmt = mysqli_prepare($conn, "Select PaymentStatusDetails From PaymentStatus Where PaymentStatusID = ?");
                mysqli_stmt_bind_param($stmt, "i", $row['PaymentStatusID']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $orderArray[$i][3]);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                $stmt = mysqli_prepare($conn, "Select OrderStatusDetails From OrderStatus Where OrderStatusID = ?");
                mysqli_stmt_bind_param($stmt, "i", $row['OrderStatusID']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $orderArray[$i][4]);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                if ($orderArray[$i][4] == "Completed"){
                    $Completed++;
                } else if ($orderArray[$i][4] == "Ongoing"){
                    $Ongoing++;
                } else if ($orderArray[$i][4] == "None"){
                    $None++;
                }

                $i++;
            }
            
            //Sum Quantity of Products Sold, Most Sold Product
            $Quantity = 0;
            $MaxQuantity = 0;
            $MostSoldProduct = 0;

            $query = "SELECT ProductID, SUM(Quantity) FROM OrderContent Group By ProductID";
            $result = mysqli_query($conn, $query);

            $orderContentRowNum = mysqli_num_rows($result);
            $orderContentArray[$orderContentRowNum][2]=array();
            $j=0;
            while($row = mysqli_fetch_array($result)){
                                                 
                $orderContentArray[$j][0]=$row['ProductID'];
                
                $orderContentArray[$j][1]=$row['SUM(Quantity)'];
                $Quantity += $orderContentArray[$j][1];

                if($orderContentArray[$j][1]>$MaxQuantity){
                    $MaxQuantity = $orderContentArray[$j][1];
                    $MostSoldProduct = $orderContentArray[$j][0];
                }

                $j++;
            }
            
            $stmt = mysqli_prepare($conn, "Select ProductName FROM Product WHERE ProductID = ?;");
            mysqli_stmt_bind_param($stmt, "i", $MostSoldProduct);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $ProductName);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        ?>
        <table align="center" cellspacing="5" cellpadding="5" class="dashboard">
            <tr>
                <td id="dashboardTableTitle">
                    Total Sales (RM)
                </td>
                <td align="left" colspan="5">
                    <?php echo $TotalSales ?>
                </td>
            </tr>
            <tr>
                <td id="dashboardTableTitle">
                    Orders
                </td>
                <td>
                    Status
                    <li>Completed : <?php echo $Completed ?></li>
                    <li>Ongoing : <?php echo $Ongoing ?></li>
                    <li>None: <?php echo $None ?></li>
                </td>
            </tr>
            <tr>
                <td id="dashboardTableTitle">
                    Most Sold Product
                </td>
                <td>
                    <?php echo $ProductName ?> : <?php echo $MaxQuantity ?>
                </td>
                <td id="dashboardTableTitle">
                    Quantity Of Products Sold
                </td>
                <td>
                    <?php echo $Quantity ?>
                </td>
            </tr>
        </table>
    </body>
</html>
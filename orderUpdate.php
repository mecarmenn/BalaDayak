<?php
    include('connect.php')
?>
<?php
    $OrderID = intval($_GET['OrderID']);
    $PaymentStatusDetails = $_GET['PaymentStatusDetails'];
    $OrderStatusDetails = $_GET['OrderStatusDetails'];

    $stmt = mysqli_prepare($conn, "Select PaymentStatusID From PaymentStatus Where PaymentStatusDetails = ?");
    mysqli_stmt_bind_param($stmt, "s", $PaymentStatusDetails);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $PaymentStatusID);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "Select OrderStatusID From OrderStatus Where OrderStatusDetails = ?");
    mysqli_stmt_bind_param($stmt, "s", $OrderStatusDetails);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $OrderStatusID);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
 
    $query = "UPDATE Orders SET PaymentStatusID = '$PaymentStatusID', OrderStatusID = '$OrderStatusID' WHERE OrderID ='$OrderID'";
    execute_query($query);
    if(mysqli_affected_rows($conn)>0){
        echo "<script type='text/javascript'>alert('Order Updated');</script>";
        $URL="order.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    } else{
        echo "There was an error in updating the table.";
    }
?>
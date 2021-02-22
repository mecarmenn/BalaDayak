<?php
    include('connect.php')
?>
<?php
$ProductID = intval($_GET['ProductID']);
$stmt = mysqli_prepare($conn, "Select ProductName, ProductDesc, Price From Product Where ProductID = ?");
mysqli_stmt_bind_param($stmt, "i", $ProductID);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ProductName, $ProductDesc, $Price);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt); 

$query = "INSERT INTO ArchivedProduct(ArchivedProductID, ProductName,ProductDesc, Price) VALUES('$ProductID','$ProductName','$ProductDesc', '$Price')";
execute_query($query);
$stmt = mysqli_prepare($conn, "Delete From Product Where ProductID = ?");
mysqli_stmt_bind_param($stmt, "i", $ProductID);
mysqli_stmt_execute($stmt);
$URL="editProduct.php";
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
mysqli_stmt_close($stmt);
?>
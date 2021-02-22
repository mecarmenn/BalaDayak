<?php
    include('connect.php')
?>
<?php
$UserID = intval($_GET['UserID']);
$stmt = mysqli_prepare($conn, "Select FullName, Username, PhoneNumber, Email, Password, Gender, Address From Member Where UserID = ?");
mysqli_stmt_bind_param($stmt, "i", $UserID);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $FullName, $Username, $PhoneNumber, $Email, $Password, $Gender, $Address);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$query = "INSERT INTO ArchivedMember VALUES('$UserID','$FullName','$Username','$PhoneNumber', '$Email', '$Password', '$Gender', '$Address')";
execute_query($query);
                                
$stmt = mysqli_prepare($conn, "Delete From Member Where UserID = ?");
mysqli_stmt_bind_param($stmt, "i", $UserID);
mysqli_stmt_execute($stmt);
$URL="dashboard.php";
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
mysqli_stmt_close($stmt);
?>
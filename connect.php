<!DOCTYPE html>
<html>
<body>
	
<?php 

$user = "root"; //Enter the user name
$password = ""; //Enter the password
$host = 'localhost'; //Enter the host
$db = 'id15580275_borndayakboutique'; //Enter the database
$conn = null;

function execute_query($query) {
    global $conn;

    $r = mysqli_query($conn, $query);

    if (!$r) {
        echo "Cannot execute query:" . mysqli_error($conn); 
    } 
}


$conn = mysqli_connect($host,$user,$password, $db);

if (!$conn) {
    echo "Could not connect to server<br>\n";
    trigger_error(mysqli_connect_error(), E_USER_ERROR);
}

?>
</body>
</html>
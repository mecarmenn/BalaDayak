<!DOCTYPE html>
<html>
<body>
	
<?php 

$user = 'root'; //Enter the user name for the database being used
$password = ''; //Enter the password for the database if none, place ''
$host = 'localhost'; //Enter the host being used to put the database
$db = 'id15580275_borndayakboutique'; //Enter the database name
$conn = null; //declaration of variable

function execute_query($query) {
    global $conn;

    $r = mysqli_query($conn, $query);

    if (!$r) {
        echo "Cannot execute query:" . mysqli_error($conn); 
    } 
}


$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    echo "Could not connect to server<br>\n";
    trigger_error(mysqli_connect_error(), E_USER_ERROR);
}

$r2 = mysqli_select_db($conn, $db);

if (!$r2) {
    echo "Cannot select database<br>\n";
    trigger_error(mysqli_error($conn), E_USER_ERROR); 
} 

//users
$query = "CREATE TABLE IF NOT EXISTS Member (
    UserID  int(10) unsigned AUTO_INCREMENT PRIMARY Key,
    FullName varchar(30) NOT NULL DEFAULT '',
    Username varchar(20) NOT NULL DEFAULT '',
    PhoneNumber INT(12) Default 000000000000,
    Email varchar(30) NOT NULL DEFAULT '', 
    Password varchar(6) NOT NULL Default '',
    Gender TEXT ,
    Address TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

//the following query is only for initialization once deployed, please comment out the following query
/*$query = "INSERT INTO Member VALUES(1,'Granger Lim', 'Granger', 0121234512,'granger@gmail.com','LimG7#', 'Female', 'Kuching, Sarawak')";
execute_query($query);*/

//the following table is to save deleted members details after a delete operation, in case of accidental deletes
//and also if there are unfinished transactions that still require the member's details

$query = "CREATE TABLE IF NOT EXISTS ArchivedMember ( 
    ArchivedUserID  int(10) unsigned AUTO_INCREMENT PRIMARY Key,
    FullName varchar(30) NOT NULL DEFAULT '',
    Username varchar(20) NOT NULL DEFAULT '',
    PhoneNumber INT(12) Default 000000000000,
    Email varchar(30) NOT NULL DEFAULT '', 
    Password varchar(6) NOT NULL Default '',
    Gender TEXT ,
    Address TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

//admin
$query = "CREATE TABLE IF NOT EXISTS Admin (
    AdminID Int(10) Auto_Increment NOT NULL PRIMARY KEY, 
    AdminUserName VARCHAR(30) NOT NULL Default'', 
    Password CHAR(6) NOT NULL
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

//the following query is only for initialization once deployed, please comment out the following query
//$query = "INSERT INTO Admin VALUES(1, 'AdminOne', 'Abc123')";
//mysqli_query($conn, $query);

//shopping cart
$query = "CREATE TABLE IF NOT EXISTS Cart (
    ItemId INT Auto_increment PRIMARY KEY , 
    ProductID INT(11) NOT NULL, 
    SizeID Int(11) NOT NULL,
    Quantity Int(11) NOT NULL DEFAULT 1,
    Price float NOT NULL DEFAULT 999.99,
    UserID int(10) unsigned NOT NULL  
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

//product
$query = "CREATE TABLE IF NOT EXISTS Product (
    ProductID INT Auto_increment PRIMARY KEY, 
    ProductName varchar(100) ,
    ProductDesc varchar(1000) ,
    Quantity_In_Stock INT(11) ,
    Price decimal(5,2) NOT NULL DEFAULT 000.00 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

//the following table is to save deleted product's details after a delete operation, in case of accidental deletes
//and also if there are unfinished transactions that still require the product's details

$query = "CREATE TABLE IF NOT EXISTS ArchivedProduct (
    ArchivedProductID INT Auto_increment PRIMARY KEY, 
    ProductName varchar(100) ,
    ProductDesc varchar(1000) ,
    Quantity_In_Stock INT(11) ,
    Price decimal(5,2) NOT NULL DEFAULT 000.00 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

//productSize
$query = "CREATE TABLE IF NOT EXISTS Size (
    SizeID INT Auto_increment PRIMARY KEY, 
    SizeName varchar(50) , 
    SizeInformation varchar(100)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

//the following query is only for initialization once deployed, please comment out the following query
/*$query = "INSERT INTO Size VALUES(1, 'XS', '78.5/60.5/86/37'), 
        (2, 'S', '81/63/88.5/38'), 
        (3, 'M', '86/68/93.5/39'),
        (4, 'L', '91/73/98.5/40'),
        (5, 'XL', '96/78/103.5/41'),
        (6, '2XL', '101/83/108.5/42')";
mysqli_query($conn, $query);*/

//orders
$query = "CREATE TABLE IF NOT EXISTS Orders (
    OrderID Int(11) AUTO_INCREMENT PRIMARY KEY,
    UserID Int(11) NOT NULL,
    TotalPrice INT(10) NOT NULL,
    DeliveryOption varchar(100),
    PaymentOption varchar(100),
    PaymentStatusID int(11),
    OrderStatusID int(11)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

$query = "CREATE TABLE IF NOT EXISTS OrderContent (
    OrderContentID Int(11) AUTO_INCREMENT PRIMARY KEY,
    OrderID Int(11) NOT NULL,
    ProductID INT(10) NOT NULL,
    SizeID INT(5) NOT NULL,
    Quantity INT(5) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

$query = "CREATE TABLE IF NOT EXISTS OrderStatus( 
    OrderStatusID int(5) AUTO_INCREMENT NOT NULL PRIMARY KEY, 
    OrderStatusDetails varchar(50) NOT NULL 
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

/*$query = "INSERT INTO OrderStatus VALUES(1, 'None'), 
        (2, 'Ongoing'), 
        (3, 'Completed')";
mysqli_query($conn, $query);*/

$query = "CREATE TABLE IF NOT EXISTS PaymentStatus( 
    PaymentStatusID int(5) AUTO_INCREMENT NOT NULL PRIMARY KEY, 
    PaymentStatusDetails varchar(50) NOT NULL 
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
execute_query($query);

/*$query = "INSERT INTO PaymentStatus VALUES(1, 'Pending'), 
        (2, 'Completed')";
mysqli_query($conn, $query);*/

//receipt table //not available but will be available if needed
?>
</body>
</html>
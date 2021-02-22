<?php 
    session_start();
    if(isset($_SESSION['AdminUserName'])){
        
        include('headerAdmin.php');
    }
    else{
        include('header.php');
    }
?>
<?php
    include('connect.php')
?>

<?php $SessionID=(isset($_SESSION['username']))?$_SESSION['username']:''; ?>

<!DOCTYPE HTML>
<html>
        <head>
            <title>Our Products</title>
            <link rel="stylesheet" id="style" href="style.css">
            <script>
                function validateAddCart(){
                if(addCart.onClick){
                    <?php if(!isset($_SESSION['username'])) { ?>
                        alert ("You have to be logged in to add to cart");
                        return false;
                    <?php } ?>
                } else {
                    return true;    
                }
                }
            </script>
        </head>
        
        <body>
            <h1>
                <center>
                    Product Details
                </center>
            </h1>
            <h2>
                <center>
                    designed by Bala Dayak Boutique
                </center>
            </h2>
            <br>
            <div>
                <form action="productS.php?id=<?php echo $_GET['id']; ?>" method="post" name="myForm" id="myForm" value="myForm" onsubmit="return(validateAddCart());">    
                    <table align="center" cellspacing="5" cellpadding="5" class="productS">
                            <tr>
                                <?php    
                                    $stmt = mysqli_prepare($conn, "Select ProductID, ProductName, ProductDesc, Price From Product Where ProductID = ?");
                                    mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_bind_result($stmt, $ProductID, $ProductName, $ProductDesc, $Price);
                                    mysqli_stmt_fetch($stmt);
                                    mysqli_stmt_close($stmt);
                                    $dirname = "products/";
                                    $images = glob($dirname."*".$ProductID.".{jpg,gif,png}",GLOB_BRACE);
                                ?>
                                
                                    <?php
                                        foreach($images as $image)
                                        {
                                    ?>
                                        <td>
                                            <?php
                                                echo '<img src="'.$image.'" width=300 height=300>';
                                            ?>
                                        </td>
                                    <?php
                                        }
                                    ?>
                            </tr>
                            <tr>
                                <td class="NamePrice" align="center" colspan="3">
                                    <?php
                                        echo $ProductName;
                                        echo " ";
                                        echo "RM";
                                        echo $Price;
                                        echo "<br>";
                                    ?>
                                </td>
                            </tr>    
                            <tr>
                                <td align="center" colspan="3">
                                <textarea id="productSDesc" rows=10 cols=60 readonly><?php echo $ProductDesc; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="SizeQuantity" align="right">Size</td>
                                <td>
                                    <select name="Size" id="Size">
                                        <?php
                                            $query = "Select SizeName From Size Limit 6";
                                            $result = mysqli_query($conn, $query);

                                            $rowNum = mysqli_num_rows($result);
                                            $sizeArray[$rowNum]=array();
                                            $i=0;
                                            while($row = mysqli_fetch_array($result)){
                                                $sizeArray[$i]=$row['SizeName'];
                                        ?>
                                                <option value="<?php echo $row['SizeName'] ?>"><?php echo $row['SizeName'] ?></option>          
                                        <?php    
                                                $i++;
                                            }

                                            
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="SizeQuantity" align="right">Quantity</td>
                                <td>
                                    <input type="number" name="Quantity" id="Quantity" min="1" value="1" step="0">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <input type="submit" class="addCart" value="Add To Cart" name="addCart" /> 
                                </td>
                            </tr>
                    </table>
                </form>
                <?php
                    if (isset($_POST['addCart'])) {
                        if(isset($_SESSION['username'])){
                        $Size = $_POST["Size"];
                        $Quantity = $_POST["Quantity"];
                        $ProductID = $_GET['id'];
                        
                        
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
                        
                        

                        $stmt = mysqli_prepare($conn, "Select Price From Product Where ProductID = ?");
                        mysqli_stmt_bind_param($stmt, "s", $ProductID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $Price);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                        
                        $query = "INSERT INTO Cart VALUES(Null,'$ProductID','$SizeID', '$Quantity', '$Price' ,'$UserID')";
                        execute_query($query);
                        mysqli_close($conn);
                    } else {
                        ?>
                        <script>
                            alert("You have to be logged in to add to cart");
                        </script>
                        <?php
                    }
                    }
                ?>
            </div>
        </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
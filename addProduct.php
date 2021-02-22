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
            <title>Add Products</title>
            <link rel="stylesheet" id="style" href="style.css">
            <script src="validateForm.js"></script>
        </head>
        
        <body>
            <h1>
                <center>
                    Welcome! Manage the boutique's product now 
                </center>
            </h1>
            <div>
                <form action="addProduct.php" method="post" name="myForm" id="myForm" value="myForm" onsubmit="return(validateAddProduct());" enctype="multipart/form-data">
                    <table align="center" cellspacing="2" cellpadding="2" class="productAdd">
                        <th colspan="2">Product Information</th>
                        <tr>
                            <td align="right">Product Name</td>
                            <td>
                                <input type="text" name="ProductName" id="ProductName">
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Product Description</td>
                            <td>
                                <textarea name="ProductDesc" id="ProductDesc" cols="30" rows="7"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Price</td>
                            <td>
                                <input type="number" name="ProductPrice" id="ProductPrice" min="0" value="0" step=".01">
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Select Image To Upload</td>
                            <td>
                                <!-- A limit of 3 images for each product in the code -->
                                <input type="file" name="fileToUpload[]" id="fileToUpload" rows=2 multiple>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="submit" value="Add" name="addProduct" /> 
                                <input type="button" value="Clear" onclick="ConfirmClear()" >
                            </td>
                        </tr> 
                    </table>
                </form>                
                <?php
                    if (!file_exists('products')) {
                        mkdir('products', 0755, true);
                    }
                    if (isset($_POST['addProduct']))
                    {
                        $ProductName = $_POST["ProductName"];
                        $ProductDesc = $_POST["ProductDesc"];
                        $ProductPrice = $_POST["ProductPrice"];
                        
                        $query = "INSERT INTO Product VALUES(Null,'$ProductName','$ProductDesc', NULL ,'$ProductPrice')";
                        execute_query($query);
                        
                        $stmt = mysqli_prepare($conn, "Select ProductID From Product Where ProductName = ?");
                        mysqli_stmt_bind_param($stmt, "s", $ProductName);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $ProductID);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                       
                        if (isset($_FILES['fileToUpload']['name'])){
                        $countfiles = count ($_FILES['fileToUpload']['name']);
                        // Where the file is going to be stored
                         $target_dir = "products/";
                         if($countfiles>3){
                            ?>
                                <script>
                                alert("The quantity of images is more than 3, do try again in the Edit Products and upload again");
                                </script>
                            <?php
                            } else{
                                for($i=0;$i<$countfiles;$i++){
                         
                                $file = $_FILES['fileToUpload']['name'][$i];
                                $path = pathinfo($file);
                                $filename = $path['filename'];
                                $ext = $path['extension'];
                                $temp_name = $_FILES['fileToUpload']['tmp_name'][$i];
                                $path_filename_ext = $target_dir.$filename.$ProductID.".".$ext;
                                
                                // Check if file already exists
                                if (file_exists($path_filename_ext)) {
                                echo "Sorry, file already exists.";
                                }else{
                                move_uploaded_file($temp_name,$path_filename_ext);
                                }
                            }
                         
                            } 
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
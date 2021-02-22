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
            <title>Edit Products</title>
            <link rel="stylesheet" id="style" href="style.css">
            <script src="validateForm.js"></script>
            <script src="editProductJS.js"></script>
        </head>
        
        <body>
            <h1>
                <center>
                    Welcome to the Product Edition page 
                </center>
            </h1>
            <div class="header-editProduct">
                <?php
                    $query="Select ProductID, ProductName, Price From Product";
                    $result = mysqli_query($conn, $query);

                    $rowNum = mysqli_num_rows($result);
                    $productArray[$rowNum][3]=array();

                    //loop to retrieve the required fields from database and store in reusable variable
                    $i=0;
                    while($row = mysqli_fetch_array($result)){
                        $productArray[$i][0]=$row['ProductID'];
                        $productArray[$i][1]=$row['ProductName'];
                        $productArray[$i][2]=$row['Price'];
                        $i++;
                    }
                ?>
                <select name="ProductList" id="ProductList" onchange="showUser(this.value)">
                    <option value="">Select a product:</option>
                    <?php 
                        for ($j=0; $j<$rowNum; $j++) {
                        ?>
                        <option value="<?php echo $productArray[$j][0] ?>"><?php echo $productArray[$j][1] ?></option>
                        <?php
                        }
                    ?>
                </select>
                <br><br>
                <div id="ProductDetails">

                </div>
                <br> <br>
                <div id="editProductForm">
                <?php 
                    if (isset($_POST['editProduct'])){
                        $ProductID = $_POST["ProductID"];
                        $stmt = mysqli_prepare($conn, "Select ProductName, ProductDesc, Price From Product Where ProductID = ?");
                        mysqli_stmt_bind_param($stmt, "i", $ProductID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $ProductName, $ProductDesc, $Price);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                        $dirname = "products/";
                        $images = glob($dirname."*".$ProductID.".{jpg,gif,png}",GLOB_BRACE);
                        ?>
                            
                            <table align="center" cellspacing="5" cellpadding="5" class="productS">
                                <th colspan="3">Product Information</th>
                                    <?php
                                        for ($k = 0; $k < count($images); $k++) {
                                            $image = $images[$k];
                                            ?>
                                                <tr>
                                                    <td>
                                                        <input type="button" id="Image[<?php echo $k?>]" value="Remove Image" name="RemoveImage" onclick="remove(this.id)"/>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $info = pathinfo($image);
                                                            $ImageName = $info["basename"];
                                                            ?>
                                                            <input class="ImageName" id='ImageName[<?php echo $k+0?>]' type='hidden' value='<?php echo $ImageName?>'/>
                                                            <input id='ProductID' type='hidden' value='<?php echo $ProductID?>'/>
                                                            <img src ="<?php echo $image ?>" id=Image[<?php echo $k+0?>] width=300 height=300/>
                                                            <?php
                                                        ?>
                                                    </td>
                                                    <td>
                                                        To change the image:
                                                        <br><br>
                                                        <form action="editProduct.php" method="post" name="ImageChange" id="ImageChange" value="ImageChange" enctype="multipart/form-data">
                                                            <input type="file" name="fileChange" id="fileChange" rows=2>
                                                            <br><br>
                                                            
                                                            <input name="ProductID" id='ProductID' type='hidden' value='<?php echo $ProductID?>'/>
                                                            <input type="submit" id="Image[<?php echo $k?>]" value="Upload Image" name="EditImage" onclick="change(this.id)"/>
                                                        </form>
                                                        
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    ?>
                                    
                            </table>
                        <br><br>
                        <form action="editProduct.php" method="post" name="myForm" id="myForm" value="myForm" onsubmit="return(validateEditProduct());" enctype="multipart/form-data">
                            <table align="center" cellspacing="2" cellpadding="2" class="productAdd">
                                <tr>
                                    <td align="right">Product Name</td>
                                    <td>
                                        <input type="text" name="ProductName" id="ProductName" value="<?php echo $ProductName ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Product Description</td>
                                    <td>
                                        <textarea name="ProductDesc" id="ProductDesc" cols="30" rows="7"><?php echo $ProductDesc ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Price</td>
                                    <td>
                                        <input type="number" name="ProductPrice" id="ProductPrice" min="0" value="<?php echo $Price ?>" step=".01">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Select Image To Upload</td>
                                    <td>
                                        <input type="file" name="fileToUpload[]" id="fileToUpload" rows=2 multiple>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="hidden" name="ProductID" value="<?php echo $ProductID ?>"/>
                                        <input type="submit" value="Save Edits" name="saveProductEdit" /> 
                                        <input type="button" value="Clear" onclick="ConfirmClear()" >
                                    </td>
                                </tr> 
                            </table>
                        </form>
                    <?php
                    }
                ?>
                </div>
                <?php
                if(isset($_POST['deleteProduct'])){
                        $ProductID = $_POST["ProductID"];               
                        ?>
                        <script>
                        if(confirm("Are you sure to delete this product?")){
                            alert("You are deleting product");
                            var Product = <?php echo $ProductID; ?>;
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("ProductDetails").innerHTML = this.responseText;
                            }
                            };
                            xmlhttp.open("GET", "deleteProduct.php?ProductID=" + Product , true);
                            xmlhttp.send();
                        } else{
                            alert("You are not deleting product");
                        } 
                        </script>
                        <?php
                    }
                ?>                
                <?php
                    if (!file_exists('products')) {
                        mkdir('products', 0755, true);
                    }
                    if (isset($_POST['saveProductEdit']))
                    {
                        $ProductID = $_POST["ProductID"];
                        $ProductName = $_POST["ProductName"];
                        $ProductDesc = $_POST["ProductDesc"];
                        $ProductPrice = $_POST["ProductPrice"];
                        
                        $query = "UPDATE Product SET ProductName = '$ProductName', ProductDesc = '$ProductDesc', Price = '$ProductPrice' WHERE ProductID ='$ProductID'";
                        execute_query($query);
                        if (!file_exists('products')) {
                            mkdir('products', 0755, true);
                        }
                        if (isset($_FILES['fileToUpload']['name'])){
                            $countfiles = count ($_FILES['fileToUpload']['name']);
                            // Where the file is going to be stored
                             $target_dir = "products/";
                             $images = glob($target_dir."*".$ProductID.".{jpg,gif,png}",GLOB_BRACE);
                             if(count($images)==3){
                                ?>
                                <script>
                                alert("Sorry, this product already have three images for it. Please first remove the images before trying again or changing the image with the desired image");
                                </script>
                                <?php
                             } elseif((count($images)==2 && $countfiles > 1) || (count($images)==1 && $countfiles > 2)){
                                ?>
                                <script>
                                alert("The quantity of images being uploaded is more than the allocated space, do reduce the quantity when trying again");
                                </script>
                                <?php
                             } elseif((count($images)==2 && $countfiles = 1) || (count($images)==1 && $countfiles = 2)){
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
                        $URL="editProduct.php";
                        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                    }
                    if(isset($_POST['EditImage'])){
                        if (isset($_FILES['fileChange']['name'])){
                            $ProductID=$_POST["ProductID"];
                            // Where the file is going to be stored
                            
                            ?>
                            <script>
                                alert("Image Changed");
                            </script>
                            <?php
                             $target_dir = "products/";
                             
                             $file = $_FILES['fileChange']['name'];
                             $path = pathinfo($file);
                             $filename = $path['filename'];
                             $ext = $path['extension'];
                             $temp_name = $_FILES['fileChange']['tmp_name'];
                             $path_filename_ext = $target_dir.$filename.$ProductID.".".$ext;
                             
                            // Check if file already exists
                            if (file_exists($path_filename_ext)) {
                                echo "Sorry, file already exists.";
                            }else{
                                move_uploaded_file($temp_name,$path_filename_ext);
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
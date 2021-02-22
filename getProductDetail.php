<?php
    include('connect.php')
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" id="style" href="style.css">
    </head>
    <body>          
        <form action="editProduct.php" method="post" name="myForm" id="myForm" value="myForm">    
                        <table align="center" cellspacing="5" cellpadding="5" class="productS">
                                <tr>
                                    <?php
                                        $ProductID = intval($_GET['ProductID']);
                                        $stmt = mysqli_prepare($conn, "Select ProductName, ProductDesc, Price From Product Where ProductID = ?");
                                        mysqli_stmt_bind_param($stmt, "i", $ProductID);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $ProductName, $ProductDesc, $Price);
                                        mysqli_stmt_fetch($stmt);
                                        mysqli_stmt_close($stmt);
                                        $dirname = "products/";
                                        $images = glob($dirname."*".$ProductID.".{jpg,gif,png}",GLOB_BRACE);
                                    ?>

                                        <?php
                                            for ($k = 0; $k < count($images); $k++) {
                                                $image = $images[$k];
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
                                    <td colspan="3" align="center">
                                        <input name="ProductID" id='ProductID' type='hidden' value='<?php echo $ProductID?>'/>
                                        <input type="submit" class="editProduct" value="Edit Product" name="editProduct" /> 
                                        <input type="submit" class="deleteProduct" value="Delete Product" name="deleteProduct" /> 
                                    </td>
                                </tr>
                        </table>
                    </form>
            <?php
        ?>
        <?php
            mysqli_close($conn);
        ?>
    </body>
</html>
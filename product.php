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


<!DOCTYPE HTML>
<html>
        <head>
            <title>Our Products</title>
            <link rel="stylesheet" id="style" href="style.css">
        </head>
        
        <body>
            <h1>
                <center>
                    Bala Dayak Boutique's Products 
                </center>
            </h1>
            <br>
            <h2>
                <center>
                    Available products
                </center>
            </h2>
            <br>
            <div class="headerProduct">
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
                    <table align="center" cellspacing="10" cellpadding="5" class="product" border="solid">
                                            
                <?php
                    $tableRow = ceil($rowNum/3);
                    $q=0;
                    for($p=0;$p<$tableRow;$p++){
                ?>
                    <tr>
                        <?php for($q;$q<$rowNum;$q++) { ?>
                            <td>
                            <?php    
                                //block to retrieve image from directory based on product ID
                                $dirname = "products/";
                                $num=0;
                                //loop to take number of images with specific productID and echo it after each iteration
                                
                                $images = glob($dirname."*".$productArray[$q][0].".{jpg,gif,png}",GLOB_BRACE);

                                foreach($images as $image)
                                {
                                    echo '<img src="'.$image.'" width=300 height=300><br />';
                                    echo $productArray[$q][1];
                                    echo " ";
                                    echo "RM";
                                    echo $productArray[$q][2];
                                    echo "<br>"; ?>
                                    <center>
                                        <a href="productS.php?id=<?php echo $productArray[$q][0]; ?>">See More</a>
                                    </center>
                                    <?php
                                    break;
                                }
                                
                            ?>
                            </td>
                        <?php 
                            if(($q+1)%3==0){
                                break;
                            }
                        } 
                        ?>
                    </tr>  
                <?php    
                    
                    }
                ?>
                
                </table>
                
                <?php
                    mysqli_close($conn);
                ?>
            </div>
        </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
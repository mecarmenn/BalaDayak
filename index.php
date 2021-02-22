<?php 
    session_start();
    include_once('databaseSetup.php');
    if(isset($_SESSION['AdminUserName'])){
        
        include_once('headerAdmin.php');
    }
    else{
        include_once('header.php');
    }
?>


<!DOCTYPE HTML>
<html>
        <head>
            <title>Bala Dayak Boutique</title>
            <link rel="stylesheet" id="style" href="style.css">
            <script src="validateForm.js" type="text/javascript"></script>

        </head>
        
        <body>
            
            <div class="header">
                <center>
                    <img src="BDB.png" alt="Bala Dayak Boutique" height="300" width="300">
                </center>
            </div>
            <section class="home-about" id="home-about">
                <h1>
                    <center>
                        A modern boutique with vintage charm
                    </center>
                </h1>
                <div class="header">
                    <center id="about-us">
                        <b>About Us</b>
                    
                    <p>
                        Bala Dayak Boutique is here to promote the luxurious and stylish clothing. You can rest assured as we ensure the best quality finish especially for you. 
                    </p>
                    
                    <p>
                        All these clothings are designed and hand-tailored by 4 talented designers. Our boutique is located in Kuching, Sarawak and operates everyday from 10am - 10 pm. 
                    </p>
                    </center>
                </div>
                <br>
            <section class="home-products" id="home-products">
                <h1>
                    <center>
                        Find Your Inner Diva
                    </center>
                </h1>
                <div class="header-product">
                    <table align="center" cellspacing="1" cellpadding="5" class="product" border="solid">
                <?php
                    $query="Select ProductID, ProductName, Price From Product Limit 3";
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
                        } 
                        ?>
                    </tr>  
                <?php    
                    
                    }
                ?>
                
                </table>
                </div>
                <br>
                <br>
                <br>
            <section class="home-contact" id="home-contact">    
                <h1>
                    <center>
                        We are one click away
                    </center>
                </h1>
                <div class="header">
                    <center>
                        Get in touch with us through these mediums
                    </center>
                    <table align="center" cellspacing="5" cellpadding="5" class="contact">
                    <tr>
                        <td>
                        <li><?php echo 
                                "<a href= https://wa.link/cvi4q0 >Whatsapp</a>" ?></li>
                    
                        </td>
                    </tr>
                    <tr>
                        <td>
                    <li><?php echo 
                                "<a href=www.facebook.com>Facebook</a>" ?></li>
                        </td>
                    </tr>
                    <tr>
                        <td>
                    <li><?php echo 
                                "<a href=www.instagram.com/baladayakboutique>Instagram</a>" ?></li>
                        </td>
                    </tr>
                    </table>
            </div>
            <br>
            <br>
            <br>
            <section class="home-enquiry" id="home-enquiry">    
                <h1>
                    <center>
                        Feedback form
                    </center>
                </h1>
                <div class="header">
                    <center>
                        Share your experience shopping with us. We would like to hear your thoughts :)
                    </center>
                    <form id="myForm" name="myForm" onsubmit="return validateEnquiry()"  method="post" action="index.php">
                        <table align="center" cellspacing="5" cellpadding="5" class="enquiry" border="solid">
                            <tr>
                                <td>
                                    Name: 
                                </td>
                                <td>
                                    <input type="text" name="Name" id="Name" placeholder="Your name" onkeypress="return AlphabetFN(event,this);">
                                    <br>
                                </td>
                                <td>
                                    Email:
                                </td>
                                <td>
                                    <input type="text" name="Email" id="Email" placeholder="Your email" >
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Subject:
                                </td>
                                <td colspan="4">
                                    <input type="text" name="Subject" id="Subject" placeholder="Your topic">
                                    <br>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Content:
                                </td>
                                <td colspan="4">
                                    <textarea name="Content" id="Content" placeholder="Your contents" cols="49" rows="7" resize="none"></textarea>
                                    <br>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input type="submit" value="Send" name="sendEnquiry" /> 
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php 
                        if (isset($_POST['sendEnquiry']))
                        {
                            $Name = $_POST['Name'];
                            $Email = $_POST['Email'];
                            $Subject = $_POST['Subject'];
                            $Content = $_POST['Content'];

                            function IsInjected($str)
                            {
                                $injections = array('(\n+)',
                                       '(\r+)',
                                       '(\t+)',
                                       '(%0A+)',
                                       '(%0D+)',
                                       '(%08+)',
                                       '(%09+)'
                                       );
                                           
                                $inject = join('|', $injections);
                                $inject = "/$inject/i";
                                
                                if(preg_match($inject,$str))
                                {
                                  return true;
                                }
                                else
                                {
                                  return false;
                                }
                            }
                            if(IsInjected($Email))
                            {
                                echo "Bad email value!";
                                exit;
                            }
                            $email_from = 'baladayakboutique01@gmail.com';

                            $email_subject = "New Enquiry submission";
                        
                            $email_body = "You have received a new message from the user $Name.\n".
                                                    "Here is the message:\n $Subject. \n".
                                                    "$Content ";  
                            
                            $to = "baladayakboutique01@gmail.com";

                            $headers = "From: $email_from \r\n";

                            $headers .= "Reply-To: $Email \r\n";

                            mail($to,$email_subject,$email_body,$headers);                          
                    ?>
                    <script> 
                        alert("Submission Successful");
                    </script>
                    <?php 
                        }
                    ?>
                </div>
        </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
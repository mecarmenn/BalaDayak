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
            <title>Admin's Dashboard</title>
            <link rel="stylesheet" id="style" href="style.css">
            <script src="validateForm.js" type="text/javascript"></script>
            <script>
            window.onload = function () {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("dashboardDetails").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "dashboardDetails.php", true);
            xmlhttp.send();

            }
            </script>
        </head>
        
        <body>
            <h1>
                <center>
                    Welcome admin <?php echo  $_SESSION['AdminUserName']; ?>
                </center>
            </h1>
            <br>
            <h3>
                <center>
                    Recent updates on Bala Dayak Boutique's Operations
                </center>
            </h3>
            <div class="header">
                <div id="dashboardDetails">

                </div>
                <br><br>
                <div>
                <?php  

                    $query = "Select UserID, FullName, Username, PhoneNumber, Email From Member";
                    $result = mysqli_query($conn, $query);

                    $memberRowNum = mysqli_num_rows($result);
                    $memberArray[$memberRowNum][5]=array();
                    $i=0;
                    while($row = mysqli_fetch_array($result)){
                        $memberArray[$i][0]=$row['UserID'];
                        $memberArray[$i][1]=$row['FullName'];
                        $memberArray[$i][2]=$row['Username'];
                        $memberArray[$i][3]=$row['PhoneNumber'];
                        $memberArray[$i][4]=$row['Email'];
                        $i++;
                    }
                    ?>
                    
                    <table align="center" cellspacing="5" cellpadding="5" border="solid" class="UserManagement">
                        <tr>
                            <td id="dashboardTableTitle">No.</td>
                            <td id="dashboardTableTitle">FullName</td>
                            <td id="dashboardTableTitle">Username</td>
                            <td id="dashboardTableTitle">PhoneNumber</td>
                            <td id="dashboardTableTitle">Email</td>
                            <td id="dashboardTableTitle">Action</td>
                        </tr>
                    <?php 
                        for ($j=0;$j<$memberRowNum; $j++) {
                    ?>
                        <tr>
                            <td><?php $listNum = $j+1; echo $listNum; ?></td>
                            <td><?php echo $memberArray[$j][1] ?></td>
                            <td><?php echo $memberArray[$j][2] ?></td>
                            <td><?php echo $memberArray[$j][3] ?></td>
                            <td><?php echo $memberArray[$j][4] ?></td>
                            <td>
                                <form action="dashboard.php" method="post" name="myForm" id="myForm" value="myForm">
                                <input type="hidden" name="UserID" value="<?php echo $memberArray[$j][0]; ?>"/>
                                <!--for debug <input type="submit" value="Test" name="test" />-->
                                <input type="submit" value="Delete" name="delete" />
                                </form>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    </table>
                    
                    <?php
                    if (isset($_POST['delete'])){
                        $UserID = $_POST['UserID'];
                        
                        $stmt = mysqli_prepare($conn, "Select Username From Member Where UserID = ?");
                        mysqli_stmt_bind_param($stmt, "i", $UserID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $Username);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                        ?>
                        
                        <script>
                           if(confirm("Are you sure to delete this user?")){
                                var User = <?php echo $UserID; ?>;
                                var xmlhttp = new XMLHttpRequest();
                                xmlhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("MemberResponse").innerHTML = this.responseText;
                                }
                                };
                                xmlhttp.open("GET", "deleteMember.php?UserID=" + User , true);
                                xmlhttp.send();
                                alert("You have deleted User: <?php echo $Username ?>");
                            } else{
                                alert("Deletion Operation Cancelled");
                            }
                            
                        </script> 
                        <?php
                    } else if (isset($_POST['test'])){
                        $UserID = $_POST['UserID'];

                        $stmt = mysqli_prepare($conn, "Select FullName, Username, PhoneNumber, Email, Password, Gender, Address From Member Where UserID = ?");
                        mysqli_stmt_bind_param($stmt, "i", $UserID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $FullName, $Username, $PhoneNumber, $Email, $Password, $Gender, $Address);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                        
                        ?>
                        <script>
                           
                           if(confirm("Are you sure to delete this user test?")){
                            alert("You are deleting user");
                            }else{
                            alert("You are not deleting user");
                            } 
                        </script>
                        <!--
                        <script>
                            alert("You have selected row with username <?php echo $Username ?> and userID <?php echo $UserID ?> ");
                        </script> -->
                    <?php
                    }
                    mysqli_close($conn);
                ?> 
                </div>
            </div>
            <div id="MemberResponse">

            </div>
        </body>
        <br><br><br>
        <footer>
            <h5>&copy December 2020, Bala Dayak Boutique All right Reserved.</h5>
        </footer>
</html>
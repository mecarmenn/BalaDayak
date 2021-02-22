<?php

// initializing variables
$Username = "";
$Email    = "";
$errors = array(); 

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'id15580275_borndayakboutique';

// connect to the database registration
$db = mysqli_connect($host, $user, $password, $database);

//register user
if (isset($_POST['registerUser'])) {
  // receive all input values from the form
  $FullName = mysqli_real_escape_string($db, $_POST['FullName']);
  $Username = mysqli_real_escape_string($db, $_POST['Username']);
  $Email = mysqli_real_escape_string($db, $_POST['Email']);
  $PhoneNumber = mysqli_real_escape_string($db, $_POST['PhoneNumber']);
  $Password_1 = mysqli_real_escape_string($db, $_POST['Password']);
  $Password_2 = mysqli_real_escape_string($db, $_POST['ConfirmPassword']);
  $Gender = mysqli_real_escape_string($db, $_POST['Gender']);
  $Address = mysqli_real_escape_string($db, $_POST['Address']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($FullName)) { array_push($errors, "Full Name is required"); }
  if (empty($Username)) { array_push($errors, "Username is required"); }
  if (empty($Email)) { array_push($errors, "Email is required"); }
  if (empty($Password_1)) { array_push($errors, "Password is required"); }
  if ($Password_1 != $Password_2) {
	array_push($errors, "The two Passwords do not match");
  }
  if (empty($Gender)) { array_push($errors, "Gender is required"); }
  if (empty($Address)) { array_push($errors, "Address is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same Username and/or Email
  $user_check_query = "SELECT * FROM Member WHERE Username='$Username' OR Email='$Email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['Username'] === $Username) {
      array_push($errors, "Username already taken");
    }

    if ($user['Email'] === $Email) {
      array_push($errors, "Email already taken");
    }
  }

  // register user if there are no errors in the form
  if (count($errors) == 0) {
  	

  	$query = "INSERT INTO Member (FullName, Username, PhoneNumber, Email, Password, Gender, Address) 
  			  VALUES('$FullName','$Username','$PhoneNumber', '$Email', '$Password_1', '$Gender', '$Address')";
  	mysqli_query($db, $query);
  	
  	if(mysqli_affected_rows($db)>0){
        $_SESSION['success'] = "You are now registered";
  	    echo "<script>location.href='login.php'</script>";
    } else{
        ?>
        <script>
            alert("Registration unsuccessful. Please try again");
        </script>
        <?php
    }
  	
  }


}
//login user
if (isset($_POST['login_user'])) 
{

  $Username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($Username)) {
    array_push($errors, "Username is required");
  }

  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $query = "SELECT * From Member where Username = '$Username' AND Password = '$password'";
    $results = mysqli_query($db, $query);
    
    $query = "SELECT Username From Member where Username = '$Username' AND Password = '$password'";
    if (mysqli_num_rows($results) == 1) {
      $results = mysqli_query($db, $query);
      $row = mysqli_fetch_assoc($results);
      $_SESSION['username'] = $row['Username'];
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
    }else {
      array_push($errors, "Wrong Username/password combination");
    }
  }
}

//login admin
if (isset($_POST['login_admin'])) 
{

  $Username = mysqli_real_escape_string($db, $_POST['adminUserName']);
  $password = mysqli_real_escape_string($db, $_POST['adminPassword']);

  if (empty($Username)) {
    array_push($errors, "Username is required");
  }

  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $query = "SELECT * From Admin where adminUserName = '$Username' AND adminPassword = '$password'";
    $results = mysqli_query($db, $query);
    
    $query = "SELECT adminUserName From Admin where AdminUserName = '$Username' AND adminPassword = '$password'";
    if (mysqli_num_rows($results) == 1) {
        $results = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($results);
        $_SESSION['AdminUserName'] = $row['adminUserName'];
        $_SESSION['success'] = "You are now logged in";
        header("location: index.php");
    }else {
      array_push($errors, "Wrong Username/password combination");
    }
  }
}

//edit user info except password
if (isset($_POST['editProfile'])) {
    // receive all input values from the form
    $UserID = mysqli_real_escape_string($db, $_POST['UserID']);
    $FullName = mysqli_real_escape_string($db, $_POST['FullName']);
    $Username = mysqli_real_escape_string($db, $_POST['Username']);
    $Email = mysqli_real_escape_string($db, $_POST['Email']);
    $PhoneNumber = mysqli_real_escape_string($db, $_POST['PhoneNumber']);
    $Gender = mysqli_real_escape_string($db, $_POST['Gender']);
    $Address = mysqli_real_escape_string($db, $_POST['Address']);

    
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($FullName)) {
        array_push($errors, "Full Name is required");
    }
    if (empty($Username)) {
        array_push($errors, "Username is required");
    }
    if (empty($Email)) {
        array_push($errors, "Email is required");
    }
    if (empty($Gender)) {
        array_push($errors, "Gender is required");
    }
    if (empty($Address)) {
        array_push($errors, "Address is required");
    }

    // first check the database to make sure
    // a user does not already exist with the same Username and/or Email
    $user_check_query = "SELECT * FROM Member WHERE Username='$Username' OR Email='$Email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
  
    if ($user) { // if user exists
        if ($user['Username'] === $Username && $user['Email'] != $Email) {
            array_push($errors, "Username already taken");
        }

        if ($user['Email'] === $Email && $user['Username'] != $Username) {
            array_push($errors, "Email already taken");
        }
    }

    // edit user if there are no errors in the form
    if (count($errors) == 0) {
        $query = "Update Member Set FullName = '$FullName', Username = '$Username', PhoneNumber = '$PhoneNumber', Email = '$Email', Gender = '$Gender', Address = '$Address' Where UserID = '$UserID'";
        mysqli_query($db, $query);
    
        if (mysqli_affected_rows($db)>0) {
            $_SESSION['success'] = "Your edit is successful";
            ?>
        <script>
            alert("Edit successful");
        </script>
        <?php
            echo "<script>location.href='memberProfile.php'</script>";
        } else {
            ?>
        <script>
            alert("Edit unsuccessful. Please make sure you have made changes before trying again or make an enquiry of this problem if it continues");
        </script>
        <?php
        }
    }
}

//edit user  password
if (isset($_POST['editPassword'])) {
  // receive all input values from the form
  $UserID = mysqli_real_escape_string($db, $_POST['UserID']);
  $CurrentPassword = mysqli_real_escape_string($db, $_POST['CurrentPassword']);
  $NewPassword = mysqli_real_escape_string($db, $_POST['NewPassword1']);
  $ConfirmNewPassword = mysqli_real_escape_string($db, $_POST['NewPassword2']);

  
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($CurrentPassword)) {
      array_push($errors, "Current Password is required");
  }
  if (empty($NewPassword)) {
      array_push($errors, "New Password is required");
  }
  if (empty($ConfirmNewPassword)) {
      array_push($errors, "Confirm New Password is required");
  }
  if ($NewPassword != $ConfirmNewPassword) {
    array_push($errors, "The two new passwords do not match");
  }

  // first check the database to make sure 
  // the user inputted the right current password
  $user_check_query = "SELECT Password FROM Member WHERE UserID='$UserID'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user['Password'] != $CurrentPassword) { // if current password given does not match user's password
      array_push($errors, "Wrong Current Password was given");
  }


  // edit user if there are no errors in the form
  if (count($errors) == 0) {
      $query = "Update Member Set Password = '$NewPassword' Where UserID = '$UserID'";
      mysqli_query($db, $query);
  
      if (mysqli_affected_rows($db)>0) {
          $_SESSION['success'] = "Your edit is successful";
          ?>
      <script>
          alert("Password Change successful");
      </script>
      <?php
          echo "<script>location.href='memberProfile.php'</script>";
      } else {
          ?>
      <script>
          alert("Password Change unsuccessful. Please try again or make an enquiry of this problem if it continues");
      </script>
      <?php
      }
  }
}

?>
<?php
session_start();
 ?>
<!DOCTYPE HTML>
<html>

<head>

 <link rel="stylesheet" type="text/css" href="menu.css">

<title> SW for Developers v1.0 BETA </title>
</head>


<body oncontextmenu="return false;">

<canvas id="canvas1" width="800" height="600" class="mainborder"> </canvas>

<div style="top: 30px; left: 20px; position: absolute;"> SuperWerer <br> for Developers </div>

<div style="top:30px; left: 620px; position: absolute;"> Version 0.0.1 BETA </div>
<br>
<br>

<div>

<form id="overlay" method="post">
<input id="input1" style="position: absolute;top: 250px; left: 200px; " type="text" name="usd" placeholder="Username">
<input id="input2" style="position: absolute;top: 250px; left: 400px; " type="password" name="pwd" placeholder="Password">
<button id="input3" style="position: absolute;top: 300px; left: 360px; " type="submit" name="login-submit">Login</button>
</form>

</div>

  <?php

/*
  if (isset($_SESSION["userId"]))
  {
  echo "<p> You are logged in! </p>";
  }

*/

if (isset($_POST['login-submit'])) {
require 'includes/dbh.inc.php';


   //Receive submitted data
  $usd = $_POST['usd'];
  $password = $_POST['pwd'];

  if (empty($usd) || empty(password)) {
    header("Location: ../developers.php?error=emptyfields");
    exit();
  }
  else{

    $sql ="SELECT * FROM mybb_users WHERE username=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../developers.php?error=sqlerror");
      exit();


    }
    else{

      mysqli_stmt_bind_param($stmt, "ss", $usd, $usd);
      mysqli_stmt_execute($stmt);
      $result= mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result)){


        //Md5 and salt user password
       function salt_password($password, $salt) {

         return md5(md5($salt).$password);
       }

       $salt = $row[salt];
       $md5pass = md5($password);

       $salted_pass = salt_password($md5pass, $salt);
       if($salted_pass == $row[password]){
         $pwdCheck = true;
       }
       else {
         $pwdCheck = false;
       }
        /*
        $pwdCheck = password_verify($password, $row['password']);
        */

        if ($pwdCheck == false){
          header("Location: developers.php?error=wrongpassword");
          exit();
        }
        else if ($pwdCheck == true){

          $_SESSION['userId'] = $row[uid];
          $_SESSION['userUid'] = $row[username];

          //Obtain User Data

          $devusername = $row[username];
          $devid = $row[uid];

          // Show User Data


echo "<div style='position: absolute;top:150px;left:650px;'>User Data</div>";
echo "<div style='position: absolute;top:200px;left:650px;'>Username: {$devusername}</div>";
echo "<div style='position: absolute;top:230px;left:650px;'>User ID: {$devid}</div>";

//Remove form
echo "<script>
var usernamefield = document.getElementById('input1');
usernamefield.style.display='none';

var passwordfield = document.getElementById('input2');
passwordfield.style.display='none';

var loginfield = document.getElementById('input3');
loginfield.style.display='none';

</script>";

        }
        else {
          header("Location: developers.php?error=wrongpassword");
          exit();
        }
      }
      else {
        header("Location: developers.php?error=nouser");
        exit();
      }
    }


  }



}
else {

  /*
  header("Location: ../developers.php");
  exit();

  */
}





   ?>





</body>


</html>

<?php
session_start();
 ?>

<!-- HTML -->
<!DOCTYPE HTML>
<html>

<head>

 <link rel="stylesheet" type="text/css" href="menu.css">

<title> SW for Developers v1.0 BETA </title>
</head>

<header>

  <h3>SuperWerer</h3><p>for Developers</p>
</header>


<body oncontextmenu="return false;">
<!-- Login form -->

<form id="overlay" method="post">
  <v-box>
  <v-box class="loginForm">
  <img src="./images/SW_logo_4.png"/>
    <h1>LOG IN</h1>

    <v-box class="inputs">
      <input id="input1" type="text" name="usd" placeholder="Forum Username"/>
      <input id="input2" type="password" name="pwd" placeholder="Forum Password"/>
      <h-box>
        <div id="forgotpassword">
          <a href="https://superwerer.com/member.php?action=lostpw" target="_blank"> Forgot password? </a>
        </div>
      </h-box>
      <button id="input3" type="submit" name="login-submit">Login</button>
    </v-box>

    <div id="logininfo"> 
      <p>Don't have a forums account yet? 
        <a href="https://superwerer.com/member.php?action=register" target="_blank">Register here!</a>
      </p>
    </div>
  </v-box>
  </v-box>
</form>



<footer>
  <p> Version 0.0.1 BETA </p>
  <div id="reportbug">
    <a href="https://superwerer.com/form.php?formid=6" target="_blank"> Report Bug </a>
  </div>
</footer>


<!-- END HTML -->


  <?php

  echo "<script>
  var logininfo = document.getElementById('logininfo');
  logininfo.style.display='block';

  var reportbug = document.getElementById('reportbug');
  reportbug.style.display='block';

  var forgotpassword = document.getElementById('forgotpassword');
  forgotpassword.style.display='flex';

  </script>";



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
          $devemail = $row[email];
          $totalviews = 0;
          $totalrevenue = 0;
          $rank = $row[usergroup];
          if($rank==22){
            $rank = "Administrator";
          }
          else if($rank==12){
            $rank = "Member";
          }
          else if($rank==13){
            $rank = "Chapter Member";
          }
          else if($rank==20){
            $rank = "Beta Tester";
          }
          else if($rank==18){
            $rank = "Trial Moderator";
          }
          else if($rank==6){
            $rank = "Moderator";
          }
          else if($rank==3){
            $rank = "Super Moderator";
          }
          else if($rank==2){
            $rank = "Registered";
          }
          else if($rank==7){
            $rank = "Banned";
          }
          else{
            $rank = "Other";
          }

// Get Title

          $query ="SELECT title FROM portal_games WHERE dev=?;";

          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $query);

          mysqli_stmt_bind_param($stmt, "s", $devusername);
          mysqli_stmt_execute($stmt);
          $queryresult= mysqli_stmt_get_result($stmt);

          echo "<div id='results' style='position:absolute;top:300px;left:30px;'></div>";

          echo "<script>
          var resultBox = document.getElementById('results');


          </script>";



          if ($queryresult){
            while($gamerow = mysqli_fetch_assoc($queryresult)) {


echo "<script>

var p = document.createElement('p');
var text = document.createTextNode('{$gamerow['title']}')
p.appendChild(text);
resultBox.appendChild(p);

</script>";



              echo "<br>";

            }
          }

        //Get Views

        $query ="SELECT noviews FROM portal_games WHERE dev=?;";

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        mysqli_stmt_bind_param($stmt, "s", $devusername);
        mysqli_stmt_execute($stmt);
        $queryresult= mysqli_stmt_get_result($stmt);

echo "<div id='results1' style='position:absolute;top:300px;left:400px;'></div>";

echo "<script>
var resultBox1 = document.getElementById('results1');

</script>";

        if ($queryresult){
          while($gamerow = mysqli_fetch_assoc($queryresult)) {
            echo "<script>

            var p = document.createElement('p');
            var text = document.createTextNode('{$gamerow['noviews']}')
            p.appendChild(text);
            resultBox1.appendChild(p);



            </script>";
            $totalviews = $totalviews + $gamerow['noviews'];

            echo "<br>";

          }
        }

        //Get revenue

        $query ="SELECT revenue FROM portal_games WHERE dev=?;";

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        mysqli_stmt_bind_param($stmt, "s", $devusername);
        mysqli_stmt_execute($stmt);
        $queryresult= mysqli_stmt_get_result($stmt);

        echo "<div id='results2' style='position:absolute;top:300px;left:500px;'></div>";

        echo "<script>
        var resultBox2 = document.getElementById('results2');

        </script>";

        echo "<br>";

        if ($queryresult){
          while($gamerow = mysqli_fetch_assoc($queryresult)) {



            echo "<script>

            var p = document.createElement('p');
            var text = document.createTextNode('{$gamerow['revenue']}$')
            p.appendChild(text);
            resultBox2.appendChild(p);

            </script>";
            $totalrevenue = $totalrevenue + $gamerow['revenue'];

            echo "<br>";


          }
        }



// User Data

echo "<div style='position: absolute;top:90px;left:30px;font-size: 35px;'>Welcome, </div>";
echo "<div style='position: absolute;top:80px;left:200px;font-size: 25px;'>{$devusername}</div>";
echo "<div style='position: absolute;top:110px;left:190px;width: 200px; height: 1px;border: 2px solid black;background-color:black;border-radius:5px;'></div>";
echo "<div style='position: absolute;top:115px;left:200px;font-size: 20px;'>{$rank}</div>";
echo "<div style='position: absolute;top:150px;left:10px;width: 800px; height: 1px;border: 2px solid black;background-color:black;'></div>";
echo "<div style='position: absolute;top:580px;left:20px;font-size: 20px;'>Last Updated: Saturday 8.June 14:00 GMT+2 </div>";

echo "<div id='gametitle' style='position: absolute;top:250px;left:30px;font-size: 20px;'>Game Title </div>";
echo "<div id='gameviews' style='position: absolute;top:250px;left:400px;font-size: 20px;'>Plays </div>";
echo "<div id='gamerevenue' style='position: absolute;top:250px;left:500px;font-size: 20px;'>Revenue </div>";

echo "<div id='totals' style='position:absolute;top: 500px;left:30px;font-size:20px;'> Total </div>";
echo "<div id='totalsviews' style='position: absolute;top:500px;left:400px;font-size: 20px;'>{$totalviews}</div>";
echo "<div id='totalsrevenue' style='position: absolute;top:500px;left:500px;font-size: 20px;'>{$totalrevenue}$</div>";

echo "<div style='position:absolute;width:150px;top:80px;left:470px;border:2px solid black;background-color:orange;font-size:20px;padding:5px;'><a href='https://superwerer.com/form.php?formid=2' target='_blank' style='text-decoration:none; color: black;'><center>Upload new <br> Game </center> </a></div>";
echo "<div style='position:absolute;width:150px;top:80px;left:640px;border:2px solid black;background-color:lightblue;font-size:20px;padding:5px;'><a href='https://superwerer.com/form.php?formid=4' target='_blank' style='text-decoration:none; color: black;'><center>Update <br> Game </center></a></div>";


echo "<script>
logininfo.style.display='none';
forgotpassword.style.display='none';

</script>";
// Categories

echo "<button onClick='gamesOpen()' class='inappbutton' id='gameinfobutton' style='top:155px;left:12px;position:absolute;'> Game Stats</button>";
echo "<button onClick='paymentOpen()' class='inappbutton' id='paymentinfobutton' style='top:155px;left:415px;position:absolute;'> Payment Settings</button>";

// Game Stats
echo "<script>
var gametitle = document.getElementById('gametitle');
gametitle.style.display='block';
var gameviews = document.getElementById('gameviews');
gameviews.style.display='block';
var gamerevenue = document.getElementById('gamerevenue');
gamerevenue.style.display='block';
var totals = document.getElementById('totals');
totals.style.display='block';
var totalsviews = document.getElementById('totalsviews');
totalsviews.style.display='block';
var totalsrevenue = document.getElementById('totalsrevenue');
totalsrevenue.style.display='block';



</script>";




echo "<script>
function gamesOpen(){
paymentmethod.style.display='none';
paypalemail.style.display='none';
resultBox.style.display='block';
resultBox1.style.display='block';
resultBox2.style.display='block';
gametitle.style.display='block';
gameviews.style.display='block';
gamerevenue.style.display='block';
totals.style.display='block';
totalsviews.style.display='block';
totalsrevenue.style.display='block';
}
</script>";


//Payment Settings

echo "<div id='paymentmethod' style='position: absolute;top:300px;left:30px;font-size:25px;'>Payment Method: Paypal</div>";
echo "<div id='paypalemail' style='position: absolute;top:350px;left:30px;font-size:25px;'>Paypal E-mail Address: {$devemail}</div>";


echo "<script>
var paymentmethod = document.getElementById('paymentmethod');
paymentmethod.style.display='none';

var paypalemail = document.getElementById('paypalemail');
paypalemail.style.display='none';
</script>";

echo "<script>
function paymentOpen(){
paymentmethod.style.display='block';
paypalemail.style.display='block';
resultBox.style.display='none';
resultBox1.style.display='none';
resultBox2.style.display='none';
gametitle.style.display='none';
gameviews.style.display='none';
gamerevenue.style.display='none';
totals.style.display='none';
totalsviews.style.display='none';
totalsrevenue.style.display='none';

}
</script>";


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

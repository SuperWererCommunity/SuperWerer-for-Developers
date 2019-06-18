<?php
if (isset($_POST['login-submit']))
{
  require 'includes/dbh.inc.php';

  //Receive submitted data
  $usd = $_POST['usd'];
  $password = $_POST['pwd'];

  if (empty($usd) || empty(password)) 
  {
    header("Location: ../developers.php?error=emptyfields");
    exit();
  }
  else
  {
    $sql ="SELECT * FROM mybb_users WHERE username=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) 
    {
      header("Location: ../developers.php?error=sqlerror");
      exit();
    }
    else
    {
      mysqli_stmt_bind_param($stmt, "ss", $usd, $usd);
      mysqli_stmt_execute($stmt);
      $result= mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result))
      {

        //Md5 and salt user password
        function salt_password($password, $salt) 
        {
          return md5(md5($salt).$password);
        }

        $salt = $row[salt];
        $md5pass = md5($password);

        $salted_pass = salt_password($md5pass, $salt);
        if($salted_pass == $row[password])
        {
          $pwdCheck = true;
        }
        else 
        {
          $pwdCheck = false;
        }


        if ($pwdCheck == false)
        {
          header("Location: developers.php?error=wrongpassword");
          exit();
        }
        else if ($pwdCheck == true)
        {
          $_SESSION['userId'] = $row[uid];
          $_SESSION['userUid'] = $row[username];

          //Obtain User Data

          $devusername = $row[username];
          $devid = $row[uid];
          $devemail = $row[email];
          $totalviews = 0;
          $totalrevenue = 0;

          $titles = [];
          $plays = [];
          $revenues = [];
          

          // Give rank according to user's rank ID
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
          

          /**
           * --------------------------------------------------------
           * GAME DATA COLLECTION
           * --------------------------------------------------------
           */

          //
          // Get Games' Titles
          //
          $query ="SELECT title FROM portal_games WHERE dev=?;";

          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $query);

          mysqli_stmt_bind_param($stmt, "s", $devusername);
          mysqli_stmt_execute($stmt);
          $queryresult= mysqli_stmt_get_result($stmt);

          if ($queryresult)
          {
            while($gamerow = mysqli_fetch_assoc($queryresult)) 
            { 
              array_push($titles, $gamerow['title']); 
            }
          }

          //
          // Get Games' Views
          //
          $query ="SELECT noviews FROM portal_games WHERE dev=?;";

          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $query);

          mysqli_stmt_bind_param($stmt, "s", $devusername);
          mysqli_stmt_execute($stmt);
          $queryresult= mysqli_stmt_get_result($stmt);

          if ($queryresult)
          {
            while($gamerow = mysqli_fetch_assoc($queryresult)) 
            {
              array_push($titles, $gamerow['noviews']);
              $totalviews += $gamerow['noviews'];
            }
          }

          //
          // Get Games' Revenue
          //
          $query ="SELECT revenue FROM portal_games WHERE dev=?;";

          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $query);

          mysqli_stmt_bind_param($stmt, "s", $devusername);
          mysqli_stmt_execute($stmt);
          $queryresult= mysqli_stmt_get_result($stmt);

          if ($queryresult)
          {
            while($gamerow = mysqli_fetch_assoc($queryresult)) 
            {
              array_push($titles, $gamerow['revenue']);
              $totalrevenue += $gamerow['revenue'];
            }
          }

          //
          // DISPLAY EVERYTHING HERE
          //
          include_once("main.php");
        }
        else 
        {
          header("Location: developers.php?error=wrongpassword");
          exit();
        }
      }
      else 
      {
        header("Location: developers.php?error=nouser");
        exit();
      }
    }
  }
}
else 
{

  /*
  header("Location: ../developers.php");
  exit();

  */
}
?>
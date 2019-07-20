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
<body oncontextmenu="return false;">


<header>
  <h3>SuperWerer</h3><p>for Developers</p>
</header>
<main>

<!-- Login form -->
<form id="login" method="post">
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

<!-- Data display here -->
<?php
require_once("grabUserData.php");
?>
</main>

<footer>
  <p> Version v1.0 </p>
  <div id="reportbug">
    <a href="https://superwerer.com/form.php?formid=6" target="_blank"> Report Bug </a>
  </div>
</footer>

</body>
</html>

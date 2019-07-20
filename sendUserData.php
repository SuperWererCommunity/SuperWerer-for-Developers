<?php
if (isset($_POST['upload-submit']))
{

 require 'includes/dbh.inc.php';

 // Submitted Game Data

 $gamename = $_POST['gameName'];
 $gamedescription = $_POST['gameDescription'];
 $gameinstructions = $_POST['gameInstructions'];
 $gamecategory = $_POST['gameCategory'];

 //Generate game's URL (Replace spaces in game name with -)

 $url = str_replace(' ', '-', $gamename);

 // Submitted Game Files

console.log($gamename);
console.log($gamedescription);
console.log($gameinstructions);
console.log($gamecategory);
console.log($url);
console.log("test");


}
else {
console.log("test");
}




?>

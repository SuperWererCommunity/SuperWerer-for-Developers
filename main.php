<section id="mainContent">

<aside>
  <h1><?=$devusername?></h1>
  <h2><?=$rank?></h2>
  <button class="tablink"> Game Stats</button>
  <button class="tablink"> Payment Settings</button>
  <button class="tablink"> Upload A Game </button>
</aside>

<article id="gameData">
  <!-- Upload and Update games buttons -->
  <h-box>
    <a href='https://superwerer.com/form.php?formid=2' target='_blank' class="button">Upload new Game</a>
    <a href='https://superwerer.com/form.php?formid=4' target='_blank' class="button">Update Game</a>
  </h-box>

  <!-- Table Headers -->
  <data-table>
    <data-header>
      <h2 id='gametitle'  >Game Title </h2>
      <h2 id='gameviews'  >Plays      </h2>
      <h2 id='gamerevenue'>Revenue    </h2>
    </data-header>
    <data-box id='dataBox'>
      <!-- Data gets inserted here -->
    </data-box>
  </data-table>

  <v-box>
    <h6>Last Updated: Monday 15.July 15:00 GMT+2</h6>
  </v-box>
</article>

<article id="paymentSettings">
  <!-- Payment Settings page elements -->
  <div id='paymentmethod' >Payment Method: Paypal</div>
  <div id='paypalemail' >Paypal E-mail Address: <?=$devemail?></div>
</article>


<article id="uploadGame">

  <h2> Upload A Game (Under Development) </h2>
 <!--- Upload Game Form -->
 <form id="upload" action="https://superwerer.com/developers.php" enctype="multipart/form-data" method="post">
   <v-box>

    <input id="inputGameName" type="text" name="gameName" placeholder="Game Name" required />
    <input id="inputGameDescription" type="textarea" name="gameDescription" placeholder="Game Description"  />
    <input id="inputGameInstructions" type="textarea" name="gameInstructions" placeholder="Game Instructions" />
    <select id="inputGameCategory" name="gameCategory">
      <option value="action"> Action </option>
      <option value="adventure"> Adventure </option>
      <option value="defense"> Defense </option>
      <option value="idle"> Idle </option>
      <option value="multiplayer"> Multiplayer </option>
      <option value="music"> Music </option>
      <option value="platformer"> Platformer </option>
      <option value="puzzle"> Puzzle </option>
      <option value="shooter"> Shooter </option>
      <option value="racing"> Racing </option>
    </select>
    <h3> Game File </h3>
    <input id="inputGameFile" type="file" name="gameFile" required/>
    <h3> Game Image/Thumbnail </h3>
    <input id="inputGameImageFile" type="file" name="gameImageFile" required/>
    <input id="inputGameTerms1" type="checkbox" name="gameTerms" required> By submitting I also clearly state
    that I own all the necessary rights to this work and it's my own original work. </input>
    <input id="inputGameTerms2" type="checkbox" name="gameTerms" required> By submitting this game I grant
    SuperWerer the right to publish this game on the SW games portal. </input>

    <button id="inputGameUpload" type="submit" name="upload-submit">Upload Game</button>

   </v-box>



 </form>



 <!-- Game Upload Script -->
 <?php
 require("sendUserData.php");
 ?>

</article>

</section>

<!-- SCRIPTS -->
<script src="helpers.js"></script>
<script>activateMainContent();</script>

<?php
//
// DISPLAY GAME DATA
//

// Display each data
for ($i = 0; $i < count($titles); ++$i)
{
  ?>
  <script>
    console.log("you've reached data display");
    console.log("count: " + <?=$i?>);
    createDataRow("<?=$titles[$i]?>", <?=$plays[$i]?>, <?=$revenues[$i]?>);
  </script>
  <?php
}
// Display totals
?>
<script>
  createTotalRow(<?=$totalviews?>, <?=$totalrevenue?>);
</script>

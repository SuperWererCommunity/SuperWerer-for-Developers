<section id="mainContent">

<aside>
  <h1><?=$devusername?></h1>
  <h2><?=$rank?></h2>
  <button class="tablink"> Game Stats</button>
  <button class="tablink"> Payment Settings</button>
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
    <h6>Last Updated: Saturday 8.June 14:00 GMT+2</h6>
  </v-box>
</article>

<article id="paymentSettings">
  <!-- Payment Settings page elements -->
  <div id='paymentmethod' >Payment Method: Paypal</div>
  <div id='paypalemail' >Paypal E-mail Address: <?=$devemail?></div>
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
    createDataRow(<?=$titles[$i]?>, <?=$plays[$i]?>, <?=$revenues[$i]?>);
  </script>
  <?php
}
// Display totals
?>
<script>
  createTotalRow(<?=$totalviews?>, <?=$totalrevenue?>);
</script>
<?php

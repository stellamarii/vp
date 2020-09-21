<?php
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  //$database = "if20_rinde_3";
  require("fnc_film.php");

  $username = "Andrus Rinde";

  require("header.php");
?>

  <img src="../pildid/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <hr>
    <ul>
    <li><a href="home.php">Avalehele</a></li>
  </ul>
  <hr>
  <?php echo readfilms(); ?>
</body>
</html>
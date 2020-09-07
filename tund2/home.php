<?php
  $uname = "Stella";
  $time = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  if($hournow < 6){
    $partofday = "uneaeg";
  }
  elseif($hournow >= 6 and $hournow < 8) {
	$partofday = "hommik";
  }
  elseif($hournow >= 8 and $hournow < 18) {
	$partofday = "kooliaeg";
  }
  elseif($hournow >= 18 and $hournow < 23) {
	$partofday = "õhtu";
  }
?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Veebileht</title>

</head>
<body>
<img src="../pildid/vp_banner.png" alt="Veebiproge kursuse bänner" >
  <h1><?php echo $uname; ?> programmeerib veebi!</h1>
  <p>Lehe avamise aeg on <?php echo $time; ?></p>
  <p>Parajasti on <?php echo $partofday; ?>!</p>
  <p><?php echo "Parajasti on " .$partofday ."."; ?></p>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiproge kursusel <a href="http://www.tlu.ee">Tallinna Ülikoolis</a>.</p>
</body>
</html>

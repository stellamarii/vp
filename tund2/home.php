<?php
  $uname = "Stella";
  $time = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  $day = date("l");
  
  if ($day = "Thursday"){
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
  else 
  
  //jälgime semestri kulgu
  $semstart = new DateTime("2020-8-31");
  $semend = new DateTime("2020-12-13");
  $semdur = $semstart->diff($semend);
  $today = new DateTime("now");
  $fromsemstart = $semstart->diff($today); //aja erinevus objektina
  $fromsemstartdays = $fromsemstart->format("%r%a");
  $semkoguaeg = $semstart->diff($semend);
  $semkoguaego = $semkoguaeg->format("%r%a");
  $dayperc = round($fromsemstartdays / $semkoguaego * 100);
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
  <p>Lehe avamise aeg on <?php echo $time .", semestri algusest on möödunud " .$fromsemstartdays ." päeva"; ?></p>
  <p>Parajasti on <?php echo $day ." ja " .$partofday; ?>!</p>
  <p></p>
  <p>Semestri kogu päevade arv: <?php echo $semkoguaego; ?></p>
  <p>Semester on kestnud <?php echo $dayperc; ?> %!</p>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiproge kursusel <a href="http://www.tlu.ee">Tallinna Ülikoolis</a>.</p>
</body>
</html>
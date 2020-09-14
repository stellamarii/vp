<?php
  //andmebaasi login info muutujad
  require ("../../../config.php");
  //salvestame formi saadetud andmed
  $database = "if20_stella_3";
  if(isset($_POST["submitnonsense"])){
	  if(!empty($_POST["nonsense"])){
		//andmebaasi lisamine ja ühenduse loomine
		$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		//SQL käsu ettevalmistus
		$stmt = $conn->prepare("INSERT INTO nonsense (nonsenseidea) VALUES(?)");
		echo $conn->error;
		$stmt->bind_param("s", $_POST["nonsense"]);
		$stmt->execute();
	  
		$stmt->close();
		$conn->close();
	  }
  }
  
  $nonsensehtml = "";
  $conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
  $stmt = $conn->prepare("SELECT nonsenseidea FROM nonsense");
  echo $conn->error;
  $stmt->bind_result($nonsensefromdb);
  $stmt->execute();
  while($stmt->fetch()){
	  $nonsensehtml .= "<p>" .$nonsensefromdb ."</p>";
  }
    $stmt->close();
  $conn->close();
  
  //mis formist serverile saadetakse?
  var_dump($_POST);
  
  $uname = "Stella";
  $time = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  
  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //küsime nädalapäeva
  $weekdaynow = date("N");
  
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

  //jälgime semestri kulgu
  $semstart = new DateTime("2020-8-31");
  $semend = new DateTime("2020-12-13");
  $semdur = $semstart->diff($semend);
  $today = new DateTime("now");
  $fromsemstart = $semstart->diff($today); //aja erinevus objektina
  $fromsemstartdays = $fromsemstart->format("%r%a");
  
  //loen kataloogist piltide nimekirja
  //$allfiles = scandir("../vp_pics/");
  //echo $allfiles; massiivi nii näidata ei saa
  //var_dump($allfiles);
  //$allpics = array_slice($allfiles, 2);
  //var_dump($allpics);
  
  $allfiles = array_slice(scandir("../vp_pics/"), 2);
  $allpics = [];
  $picfiletypes = ["image/jpeg", "image/png"];
  //uurime kas on pildid v ei
  foreach ($allfiles as $file){
	  $fileinfo = getImagesize("../vp_pics/" .$file);
	  if(in_array($fileinfo["mime"], $picfiletypes) == true){
		  array_push($allpics, $file);
	  }
  }
  
  //paneme kõik pildid järjest ekraanile
  //uurime mitu pilti on
  $piccount = count($allpics);
  $imghtml = "";
  for($i = 0; $i < $piccount; $i++){
	  $imghtml .= '<img src="../vp_pics/' .$allpics[$i] .'" ';
	  $imghtml .= 'alt ="Tallinna Ülikool">';
  }
  
  require("header.php");
?>

<img src="../pildid/vp_banner.png" alt="Veebiproge kursuse bänner" >
  <h1><?php echo $uname; ?> programmeerib veebi!</h1>
  <p>Lehe avamise aeg on <?php echo $weekdayNamesET[$weekdaynow-1] .", " .$time; ?></p>
  <p>Lehe avamise aeg on <?php echo $time .", semestri algusest on möödunud " .$fromsemstartdays ." päeva"; ?></p>
  <p>Parajasti on <?php echo $partofday; ?>!</p>
  <p><?php echo "Parajasti on " .$partofday ."."; ?></p>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiproge kursusel <a href="http://www.tlu.ee">Tallinna Ülikoolis</a>.</p>
  
  <hr>
  <form method="POST">
	<label>Sisesta oma tänane mõttetu mõte!</label>
	<input type="text" name="nonsense" placeholder="mõttekoht">
	<input type="submit" value="saada ära" name="submitnonsense">
  
  </form>
  
  <hr>
  <?php echo $nonsensehtml; ?>
  
  <hr>
  <?php echo $imghtml; ?>
  
</body>
</html>
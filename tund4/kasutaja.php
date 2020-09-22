<?php
	require("../../../config.php");
	
	$inputerror="";
	$enimi="";
	$pnimi="";
	$email="";
	$parool="";
	$parool2="";
	if(isset($_POST["kasutajavalmis"])){
		$enimi=$_POST["enimisisestus"];
		$pnimi=$_POST["pnimisisestus"];
		$email=$_POST["emailsisestus"];
		$parool=$_POST["paroolsisestus"];
		$parool2=$_POST["parool2sisestus"];
/* 		if(empty($_POST["titleinput"]) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
			$inputerror .= "Osa vajalikku infot on sisestamata! ";
		}
		if($_POST["yearinput"] > date("Y") or $_POST["yearinput"] < 1895){
			$inputerror .= "Ebareaalne valmimisaasta! ";
		}
		if($_POST["durationinput"] < 0){
			$inputerror .= "Ebareaalne kestus! ";
		}
		if(empty($inputerror)){
			writefilm($_POST["titleinput"], $_POST["yearinput"], $_POST["durationinput"], $_POST["genreinput"], $_POST["studioinput"], $_POST["directorinput"]);
		} */
	}
	
	require("header.php");
?>
	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
	</ul>
	
	<hr>
	<p>Siin saad endale kasutaja teha!</p>
	<form method="POST">
		<label for="enimisisestus">Eesnimi: </label>
		<input type="text" name="enimisisestus" id="enimisisestus" placeholder="Eesnimi" value="<?php echo $enimi; ?>">
		<br>
		<label for="pnimisisestus">Perekonnanimi: </label>
		<input type="text" name="pnimisisestus" id="pnimisisestus" placeholder="Eesnimi" value="<?php echo $pnimi; ?>">
		<br>
		<label for="msugusisestus">Mees</label>
		<input type="radio" name="sugusisestus" id="msugu" value="1">
		<!--<?php if($gender == "1"){echo " checked";}?>??????-->
		<br>
		<label for="nsugusisestus">Naine</label>
		<input type="radio" name="sugusisestus" id="nsugu" value="2">
		<!--<?php if($gender == "1"){echo " checked";}?>??????-->
		<br>
		<label for="emailsisestus">E-mail: </label>
		<input type="email" name="emailsisestus" id="emailsisestus" placeholder="Email" value="<?php echo $email; ?>">
		<br>
		<label for="paroolsisestus">Parool: </label>
		<input type="password" name="paroolsisestus" id="paroolsisestus" placeholder="Parool" value="<?php echo $parool; ?>">
		<br>
		<label for="parool2sisestus">Parool uuesti: </label>
		<input type="password" name="parool2sisestus" id="parool2sisestus" placeholder="Parool uuesti" value="<?php echo $parool2; ?>">
		<br>
		<input type="submit" name="kasutajavalmis" value="Salvesta">
	</form>
	<p><?php echo $inputerror; ?></p>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
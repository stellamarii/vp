<?php
	require("../../../config.php");
	require("fnc_common.php");

	$enimierror="";
	$pnimierror="";
	$suguerror="";
	$birthdateerror="";
	$birthdayerror="";
	$birthmontherror="";
	$birthyearerror="";
	$emailerror="";
	$paroolerror="";
	$parool2error="";
	
	$enimi="";
	$pnimi="";
	$sugu="";
	$birthdate= null;
	$birthday= null;
	$birthmonth= null;
	$birthyear= null;
	$email="";
	$parool="";
	$parool2="";
	
	if(isset($_POST["kasutajavalmis"])){
		$enimi=$_POST["enimisisestus"];
		$pnimi=$_POST["pnimisisestus"];
		$email=$_POST["emailsisestus"];
		if(!empty($_POST["enimisisestus"])){
			$enimi = test_ipnut($_POST["enimisisestus"]);
		} else {
			$enimierror .= "Eesnimi on sisestamata! " ."<br>";
		}
		if(!empty($_POST["pnimisisestus"])){
			$pnimi = test_ipnut($_POST["pnimisisestus"]);
		} else {
			$pnimierror .= "Perekonnanimi on sisestamata! " ."<br>";
		}
		if(!isset($_POST["sugusisestus"])){
			$sugu = $_POST["genderinput"];
		} else {
			$suguerror= "Sugu on märkimata!";
		}
		if(!empty($_POST["emailsisestus"])){
			$email = test_ipnut($_POST["emailsisestus"]);
		} else {
			$emailerror .= "Email on sisestamata! " ."<br>";
		}
		if(!empty($_POST["paroolsisestus"])){
			$paroolerror .= "Parool on sisestamata! " ."<br>";
		}
		if(!empty($_POST["parool2sisestus"])){
			$parool2error .= "Parooli pole korratud! " ."<br>";
		}
		/* if(empty($inputerror)){
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
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label for="enimisisestus">Eesnimi: </label>
		<input type="text" name="enimisisestus" id="enimisisestus" placeholder="Eesnimi" value="<?php echo $enimi; ?>"><span><?php echo $enimierror; ?></span>
		<br>
		<label for="pnimisisestus">Perekonnanimi: </label>
		<input type="text" name="pnimisisestus" id="pnimisisestus" placeholder="Eesnimi" value="<?php echo $pnimi; ?>"><span><?php echo $pnimierror; ?></span>
		<br>
		<label for="msugusisestus">Mees:</label>
		<input type="radio" name="sugusisestus" id="msugusisestus" value="1" <?php if($sugu == "1"){echo " checked";}?>>
		<label for="nsugusisestus">Naine:</label>
		<input type="radio" name="sugusisestus" id="nsugusisestus" value="2" <?php if($sugu == "2"){echo " checked";}?>><span><?php echo $suguerror; ?></span>
		<br>
		<br>
		
		
		<label for="birthdayinput">Sünnipäev: </label>
			<?php
				echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
				echo '<option value="" selected disabled>päev</option>' ."\n";
				for ($i = 1; $i < 32; $i ++){
					echo '<option value="' .$i .'"';
					if ($i == $birthday){
						echo " selected ";
					}
					echo ">" .$i ."</option> \n";
				}
				echo "</select> \n";
			?>
		<label for="birthmonthinput">Sünnikuu: </label>
		<?php
			echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
			echo '<option value="" selected disabled>kuu</option>' ."\n";
			for ($i = 1; $i < 13; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthmonth){
					echo " selected ";
				}
				echo ">" .$monthnameset[$i - 1] ."</option> \n";
			}
			echo "</select> \n";
		?>
		<label for="birthyearinput">Sünniaasta: </label>
		<?php
			echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
			echo '<option value="" selected disabled>aasta</option>' ."\n";
			for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
				echo '<option value="' .$i .'"';
				if ($i == $birthyear){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		?>
		<br>
		<span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
		
		<br>
		<br>
		<label for="emailsisestus">E-mail: </label>
		<input type="email" name="emailsisestus" id="emailsisestus" placeholder="Email" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
		<br>
		<label for="paroolsisestus">Parool: </label>
		<input type="password" name="paroolsisestus" id="paroolsisestus" placeholder="Parool"><span><?php echo $paroolerror; ?></span>
		<br>
		<label for="parool2sisestus">Parool uuesti: </label>
		<input type="password" name="parool2sisestus" id="parool2sisestus" placeholder="Parool uuesti"><span><?php echo $parool2error; ?></span>
		<br>
		<input type="submit" name="kasutajavalmis" value="Salvesta">
	</form>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
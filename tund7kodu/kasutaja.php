<?php
	require("../../../config.php");
	require("fnc_common.php");
	require("fnc_kasutaja.php");

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
	$monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	
	if(isset($_POST["kasutajavalmis"])){
		$enimi=$_POST["enimisisestus"];
		$pnimi=$_POST["pnimisisestus"];
		$email=$_POST["emailsisestus"];
		if(!empty($_POST["enimisisestus"])){
			$enimi = test_input($_POST["enimisisestus"]);
		} else {
			$enimierror .= "Eesnimi on sisestamata! " ."<br>";
		}
		if(!empty($_POST["pnimisisestus"])){
			$pnimi = test_input($_POST["pnimisisestus"]);
		} else {
			$pnimierror .= "Perekonnanimi on sisestamata! " ."<br>";
		}
		if(isset($_POST["sugusisestus"])){
			$sugu = $_POST["sugusisestus"];
		} else {
			$suguerror= "Sugu on märkimata!";
		}
		
		if(!empty($_POST["birthdayinput"])){
			$birthday = intval($_POST["birthdayinput"]);
		} else {
			$birthdayerror = "Palun vali sünnikuupäev!";
		}
		if(!empty($_POST["birthmonthinput"])){
			$birthmonth = intval($_POST["birthmonthinput"]);
		} else {
			$birthmontherror = "Palun vali sünnikuu!";
		}
		if(!empty($_POST["birthyearinput"])){
			$birthyear = intval($_POST["birthyearinput"]);
		} else {
			$birthyearerror = "Palun vali sünniaasta!";
		}
		
		if(!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
			if(checkdate($birthmonth, $birthday, $birthyear)){
				$tempdate = new DateTime($birthyear ."-" .$birthmonth ."-" .$birthday);
				$birthdate = $tempdate->format("Y-m-d");
				//echo $birthdate;
			} else {
				$birthdateerror = "Kuupäev on vigane!";
			}
		}
		
		
		if(!empty($_POST["emailsisestus"])){
			$email = test_input($_POST["emailsisestus"]);
		} else {
			$emailerror .= "Email on sisestamata! " ."<br>";
		}
		if(empty($_POST["paroolsisestus"])){
			$paroolerror .= "Parool on sisestamata! " ."<br>";
		}
		if(empty($_POST["parool2sisestus"])){
			$parool2error .= "Parooli pole korratud! " ."<br>";
		}
		if(empty($enimierror) and empty($pnimierror) and empty($suguerror ) and empty($emailerror) and empty($paroolerror) and empty($parool2error) and empty($birthdateerror) and empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror)){
		$result = signup($enimi, $pnimi, $email, $sugu, $birthdate, $_POST["paroolsisestus"]);
		//$notice = "Kõik korras!";
		if($result == "ok"){
			$enimi= "";
			$pnimi = "";
			$sugu = "";
			$email = "";
			$birthdate= null;
			$birthday= null;
			$birthmonth= null;
			$birthyear= null;
			$notice = "Kasutaja loomine õnnestus!";
		} else {
			$notice = "Kahjuks tekkis tehniline viga: " .$result;
		}
		}
	}
	
	require("header.php");
?>
	<hr>
    <ul>
		<li><a href="page.php">Avalehele</a></li>
	</ul>
	
	<hr>
	<p>Siin saad endale kasutaja teha!</p>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label for="enimisisestus">Eesnimi: </label>
		<input type="text" name="enimisisestus" id="enimisisestus" placeholder="Eesnimi" value="<?php echo $enimi; ?>"><span><?php echo $enimierror; ?></span>
		<br>
		<br>
		<label for="pnimisisestus">Perekonnanimi: </label>
		<input type="text" name="pnimisisestus" id="pnimisisestus" placeholder="Eesnimi" value="<?php echo $pnimi; ?>"><span><?php echo $pnimierror; ?></span>
		<br>
		<br>
		<label for="sugusisestus">Mees:</label>
		<input type="radio" name="sugusisestus" id="msugusisestus" value="1" <?php if($sugu == "1"){echo " checked";}?>>
		<label for="sugusisestus">Naine:</label>
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
		<label for="emailsisestus">E-mail: </label>
		<input type="email" name="emailsisestus" id="emailsisestus" placeholder="Email" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
		<br>
		<br>
		<label for="paroolsisestus">Parool: </label>
		<input type="password" name="paroolsisestus" id="paroolsisestus" placeholder="Parool"><span><?php echo $paroolerror; ?></span>
		<br>
		<br>
		<label for="parool2sisestus">Parool uuesti: </label>
		<input type="password" name="parool2sisestus" id="parool2sisestus" placeholder="Parool uuesti"><span><?php echo $parool2error; ?></span>
		<br>
		<br>
		<input type="submit" name="kasutajavalmis" value="Salvesta">
	</form>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
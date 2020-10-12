<?php
session_start();
	require("fnc_kasutaja.php");
	require("../../../config.php");
	require("fnc_common.php");
	
	$notice = "";
	$nimi = "Stella-Marii";
	$kuupäev = date("d");
	$kuu = date("m");
	$aasta = date("Y");
	$tund = date("H");
	$minut = date("i");
	$sekund = date("s");
	$nädalapäev = date("N");
	$semesteralg = new DateTime("2020-8-31");
	$semesterlõpp = new DateTime("2020-12-13");
	$täna = new DateTime("now");
	
	$aeg = "aeg";
	$päevnimi = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$kuunimi = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	
	//if $nädalapäev <= 5 {
		if($tund < 6){
			$aeg = "uneaeg";
		}
		elseif($tund >= 6 and $tund < 8) {
			$aeg = "hommik";
		}
		elseif($tund >= 8 and $tund < 18) {
			$aeg = "kooliaeg";
		}
		elseif($tund >= 18 and $tund <= 23) {
			$aeg = "õhtu";
		}
	//}
/* 	elseif $nädalapäev == 6 or $nädalapäev ==7 {
		if($tund < 10) {
			$aeg = "uneaeg";
		}
		elseif($tund >= 10 and $tund < 12) {
			$aeg = "hommik";
		}
		elseif($tund >= 12 and $tund < 20) {
			$aeg = "lebotamisaeg";
		}
		elseif($tund >= 20 and $tund <= 23) {
			$aeg = "filmiaeg";
		}
	} */
	
	$semesterkestabb = $semesteralg->diff($semesterlõpp);
	$semesterkestab = $semesterkestabb->format("%r%a");
	$semestrialgusestb = $semesteralg->diff($täna);
	$semestrialgusest = $semestrialgusestb->format("%r%a");
	$semestriprotsent = round($semestrialgusest/$semesterkestab*100);
	
/* 	if $semestrialgusest < 0 {
		$semester = "Semester pole alanud!";
	}
	elseif $semestrialgusest/$semesterkestab*100 > 100 {
		$semester = "Semester on läbi!";
	}
	else {
		$semestriprotsentb = round($semestrialgusest/$semesterkestab*100);
	} */
	
	$failid = array_slice(scandir("../vp_pics/"), 2);
	$pildid = [];
	$pildiformaat = ["image/jpeg", "image/png"];
	foreach ($failid as $fail) {
		$failiformaat = getImagesize("../vp_pics/" .$fail);
		if(in_array($failiformaat["mime"], $pildiformaat) == true) {
			array_push($pildid, $fail);
		}
	}
	$pilte = count($pildid);
	$pilthtml = "";
	$pilthtml .= '<img src="../vp_pics/' .$pildid[mt_rand(0, ($pilte - 1))] .'" ';
	$pilthtml .= 'alt ="Tallinna Ülikool">';
	
	$email = "";

	$emailerror = "";
	$passworderror = "";
	$notice = "";
	if(isset($_POST["kasutjasignin"])){
		if (!empty($_POST["emailsisestus"])){
			//$email = test_input($_POST["emailsisestus"]);
			$email = filter_var($_POST["emailsisestus"], FILTER_SANITIZE_EMAIL);
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			} else {
			  $emailerror = "Palun sisesta õige kujuga e-postiaadress!";
			}		
		} else {
			$emailerror = "Palun sisesta e-postiaadress!";
		}

		if (empty($_POST["paroolsisestus"])){
			$passworderror = "Palun sisesta salasõna!";
		} else {
			if(strlen($_POST["paroolsisestus"]) < 8){
				$passworderror = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["paroolsisestus"]) ." märki).";
			}
		}

		if(empty($emailerror) and empty($passworderror)){
			echo "Juhhei!" .$email .$_POST["paroolsisestus"];
			$notice = signin($email, $_POST["paroolsisestus"]);
		}
	}

	require("header.php");
?>
	<hr>
	<h2>Logi sisse:</h2>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="emailsisestus">E-mail: </label>
		<input type="email" name="emailsisestus" id="emailsisestus" placeholder="Email"><span><?php echo $emailerror; ?></span>
		<br><br>
		<label for="paroolsisestus">Parool: </label>
		<input type="password" name="paroolsisestus" id="paroolsisestus" placeholder="Parool"><span><?php echo $passworderror; ?></span>
		<br><br>
		<input type="submit" name="kasutjasignin" value="Logi sisse">
	</form>
	
	<hr>
	<ul>
		<li><a href="kasutaja.php">Kasutajakonto loomine</a></li>
	</ul>
	
	<hr>
	<?php echo $pilthtml; ?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiproge kursusel <a href="http://www.tlu.ee">Tallinna Ülikoolis</a>.</p>
	
</body>
</html>
<?php
	
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
	
	
	require("header.php");
?>
	<hr>
	<ul>
		<li><a href="kasutaja.php">Kasutaja loomine</a></li>
		<li><a href="mõtelisa.php">Mõtete lisamine</a></li>
		<li><a href="mõtenimekiri.php">Mõtete lugemine</a></li>
		<li><a href="filmlisa.php">Filmiinfo lisamine</a></li>
		<li><a href="filmnimekiri.php">Filmiinfo</a></li>
		<li><a href="page.php">Logi välja</a></li>
	</ul>
	
	<hr>
	<p>Praegu on <?php echo $päevnimi[$nädalapäev-1] .", " .$kuupäev .". " .$kuunimi[$kuu-1] ." " .$aasta ."."; ?></p>
	
	<p>Semestri algusest on möödunud <?php echo $semestrialgusest ." päeva."; ?></p>
	<p>Semester on kestnud <?php echo $semestriprotsent ."%."; ?></p>
	<p>Kell on <?php echo $tund .":" .$minut .":" .$sekund; ?> ning hetkel on <?php echo $aeg ."."; ?></p>
	
	<hr>
	<?php echo $pilthtml; ?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiproge kursusel <a href="http://www.tlu.ee">Tallinna Ülikoolis</a>.</p>
	
</body>
</html>
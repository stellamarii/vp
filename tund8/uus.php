<?php
	session_start();
	
	if(!isset($_SESSION["kasutajaid"])){
		header("Location: page.php");
	}
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
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
	<h1><?php echo $_SESSION["kasutajaenimi"]; ?> programmeerib veebi!</h1>
	
	<hr>
	<ul>
		<li><a href="kasutaja.php">Kasutaja loomine</a></li>
		<li><a href="kasutajaprofiil.php">Profiili loomine</a></li>
		<li><a href="photoupload.php">Piltide üleslaadimine</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
		<hr>
		<li><a href="mõtelisa.php">Mõtete lisamine</a></li>
		<li><a href="mõtenimekiri.php">Mõtete lugemine</a></li>
		<hr>
		<li><a href="filmlisa.php">Filmiinfo lisamine</a></li>
		<li><a href="filmnimekiri.php">Filmiinfo</a></li>
		<li><a href="filmseosed.php">Filmide seosed</a></li>
		<li><a href="näitlejateandmed.php">Näitlejate andmed</a></li>
		<li><a href="addfilmdata.php">Filmi andmete lisamine</a></li>
		<li><a href="addfilmrelations.php">Filmi seoste lisamine</a></li>
		<li><a href="http://greeny.cs.tlu.ee/phpmyadmin">Andmebaasid</a></li>
	</ul>
	
	<hr>
	<?php echo $pilthtml; ?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiproge kursusel <a href="http://www.tlu.ee">Tallinna Ülikoolis</a>.</p>
	
</body>
</html>
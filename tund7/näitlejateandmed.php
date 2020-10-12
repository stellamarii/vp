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
	
	require("../../../config.php");
	require("fnc_filmseosed.php");
	
	$sortby = 0;
	$sortorder = 0;
	
	require("header.php");
?>
	<h1><?php echo $_SESSION["kasutajaenimi"]; ?> programmeerib veebi!</h1>
	
	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
		<li><a href="filmlisa.php">Filmiinfo lisamine</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	
	<hr>
	<?php 
		if(isset($_GET["sortby"]) and isset($_GET["sortorder"])){
			if($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4){
				$sortby = $_GET["sortby"];
			}
			if($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2){
				$sortorder = $_GET["sortorder"];
			}
		}
		echo readfromdb($sortby, $sortorder); 
	?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
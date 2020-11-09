<?php
	//SESSIOON (katkeb kui brauser suletakse)
	require("classes/session.class.php");
	SessionManager::sessionStart("vp", 0, "/~steltam/", "greeny.cs.tlu.ee");
	
	if(!isset($_SESSION["kasutajaid"])){
		header("Location: page.php");
	}
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	require("../../../config.php");
	require("fnc_photo.php");
	
	$notice = "";
	$origphotodir = "../photoupload_orig/";
	$normalphotodir = "../photoupload_normal/";
	$thumbphotodir = "../../../briarat/public_html/VP/photoupload_normal";
	
	//loen sisse pildid, mille privaatsus 2 v 3
	$publicphotothumbsHTML = readpublicphotothumbs(2);
	
	
	require("header.php");
?>
	<h1><?php echo $_SESSION["kasutajaenimi"]; ?> programmeerib veebi!</h1>
	
	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	
	<hr>
	<h2>Pildigalerii</h2>
	<?php echo $publicphotothumbsHTML; ?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
















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
	require("fnc_kasutaja.php");

	$notice = "";
	$description = readdescription();
	
	if(isset($_POST["profilesubmit"])){
		$notice = storeuserprofile($_POST["descriptioninput"], $_POST["bgcolorinput"], $_POST["txtcolorinput"]);
		$description = $_POST["descriptioninput"];
		$_SESSION["bgcolor"] = $_POST["bgcolorinput"];
		$_SESSION["txtcolor"] = $_POST["txtcolorinput"];
	}
	

	require("header.php");
?>
	<h1><?php echo $_SESSION["kasutajaenimi"] ." " ,$_SESSION["kasutajapnimi"]; ?> kasutajaprofiil!</h1>
	
	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="descriptioninput">Lühitutvustus: </label> <br>
		<textarea rows="10" cols="80" name="descriptioninput" id="descriptioninput" placeholder="Minu tutvustus..."><?php echo $description; ?></textarea>
		<br>
		
		<label for="bgcolorinput">Taustavärv: </label>
		<input type="color" name="bgcolorinput" id="bgcolorinput" value="<?php echo $_SESSION["bgcolor"]; ?>">
		<br>
		
		<label for="txtcolorinput">Teksti värv: </label>
		<input type="color" name="txtcolorinput" id="txtcolorinput" value="<?php echo $_SESSION["txtcolor"]; ?>">
		<br>
		
		<input type="submit" name="profilesubmit" value="Salvesta profiil">
	</form>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
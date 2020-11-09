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
	require("fnc_film.php");
	$inputerror="";
	$title="";
	$year=date("Y");
	$duration="80";
	$genre="";
	$studio="";
	$director="";
	if(isset($_POST["filmsubmit"])){
		$title=$_POST["titleinput"];
		$year=$_POST["yearinput"];
		$duration=$_POST["durationinput"];
		$genre=$_POST["genreinput"];
		$studio=$_POST["studioinput"];
		$director=$_POST["directorinput"];
		if(empty($_POST["titleinput"]) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
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
		}
	}
	require("header.php");
?>

	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
		<li><a href="filmnimekiri.php">Filmiinfo</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>
		<label for="titleinput">Filmi pealkiri: </label>
		<input type="text" name="titleinput" id="titleinput" placeholder="Pealkiri" value="<?php echo $title; ?>">
		<br>
		<label for="yearinput">Filmi valmimisaasta: </label>
		<input type="number" name="yearinput" id="yearinput" value="<?php echo $year; ?>">
		<br>
		<label for="durationinput">Filmi kestus: </label>
		<input type="number" name="durationinput" id="durationinput" value="<?php echo $duration; ?>">
		<br>
		<label for="genreinput">Filmi žanr: </label>
		<input type="text" name="genreinput" id="genreinput" placeholder="Žanr" value="<?php echo $genre; ?>">
		<br>
		<label for="studioinput">Filmi tootja/stuudio: </label>
		<input type="text" name="studioinput" id="studioinput" placeholder="Tootja/stuudio" value="<?php echo $studio; ?>">
		<br>
		<label for="directorinput">Filmi lavastaja: </label>
		<input type="text" name="directorinput" id="directorinput" placeholder="Eesnimi Perenimi" value="<?php echo $director; ?>">
		<br>
		<input type="submit" name="filmsubmit" value="Salvesta">
	</form>
	<p><?php echo $inputerror; ?></p>
	
	<h1><?php echo $_SESSION["kasutajaenimi"]; ?> programmeerib veebi!</h1>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
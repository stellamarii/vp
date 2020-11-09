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
	require("fnc_filmseosed.php");
	
	$gendrenotice = "";
	$studionotice = "";
	$selectedfilm = "";
	$selectedgenre = "";
	$selectedstudio = "";
	
	if(isset($_POST["filmstudiosubmit"])){
		if(!empty($_POST["filminput"])){
			$selectedfilm = intval($_POST["filminput"]);
		} else {
			$studionotice = " Vali film!";
		}
		if(!empty($_POST["filmstudioinput"])){
			$selectedstudio= intval($_POST["filmstudioinput"]);
		} else {
			$studionotice .= " Vali stuudio!";
		}
		if(!empty($selectedfilm) and !empty($selectedstudio)){
			$studionotice = storenewstudiorelation($selectedfilm, $selectedstudio);
		}
	}
	
	if(isset($_POST["filmgenresubmit"])){
		//$selectedfilm = $_POST["filminput"];
		if(!empty($_POST["filminput"])){
			$selectedfilm = intval($_POST["filminput"]);
		} else {
			$notice = " Vali film!";
		}
		if(!empty($_POST["filmgenreinput"])){
			$selectedgenre = intval($_POST["filmgenreinput"]);
		} else {
			$notice .= " Vali žanr!";
		}
		if(!empty($selectedfilm) and !empty($selectedgenre)){
			$notice = storenewrelation($selectedfilm, $selectedgenre);
		}
	}
	
	$filmselecthtml = readmovietoselect($selectedfilm);
	$filmgenreselecthtml = readgenretoselect($selectedgenre);
	$filmstudioselecthtml = readstudiotoselect($selectedstudio);
	
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
	<h2>Määrame filmile stuudio</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<?php
			echo $filmselecthtml;
			echo $filmstudioselecthtml;
		?>
		<input type="submit" name="filmstudiosubmit" value="Salvesta seos stuudioga"><span><?php echo $studionotice; ?></span>
	</form>
	
	<hr>
	<label for="filminput">Film: </label>
	<select name="filminput" id="filminput">
		<option value="" <?php echo filmdrop();?></option>
	</select>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
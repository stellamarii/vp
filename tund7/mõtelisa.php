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
	
	$database = "if20_stella_3";
	if(isset($_POST["mõtesisestus"])){
		if(!empty($_POST["mõte"])){
			$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
			$stmt = $conn->prepare("INSERT INTO nonsense (nonsenseidea) VALUES(?)");
			echo $conn->error;
			$stmt->bind_param("s", $_POST["mõte"]);
			$stmt->execute();
		
			$stmt->close();
			$conn->close();
		}
	}
	
	require("header.php");
?>
	<h1><?php echo $_SESSION["kasutajaenimi"]; ?> programmeerib veebi!</h1>
	
	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
		<li><a href="mõtenimekiri.php">Mõtete lugemine</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	
	<hr>
	<p>Siin saad lisada mõtteid!</p>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>
		<label>Sisesta oma mõte:</label>
		<input type="text" name="mõte" placeholder="mõttekoht">
		<input type="submit" value="Saada ära" name="mõtesisestus">
	</form>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
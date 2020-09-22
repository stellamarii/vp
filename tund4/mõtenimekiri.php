<?php
	require("../../../config.php");
	
	$database = "if20_stella_3";
	$mõtehtml = "";
	$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	$stmt = $conn->prepare("SELECT nonsenseidea FROM nonsense");
	echo $conn->error;
	$stmt->bind_result($mõteab);
	$stmt->execute();
	while($stmt->fetch()){
		$mõtehtml .= "<p>" .$mõteab ."</p>";
	}
	$stmt->close();
	$conn->close();
	
	require("header.php");
?>
	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
		<li><a href="mõtelisa.php">Mõtete lisamine</a></li>
	</ul>
	
	<hr>
	<p>Siin saad vaadata sisestatud mõtteid!</p>
	<?php echo $mõtehtml; ?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
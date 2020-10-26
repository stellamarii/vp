<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebileht</title>
	<style>
	<?php
		echo "body { \n";
		if(isset($_SESSION["bgcolor"])){
			echo "background-color: " .$_SESSION["bgcolor"] ."; \n";
		}
		if(isset($_SESSION["txtcolor"])){
			echo "color: " .$_SESSION["txtcolor"] .";\n";
		}
		echo "} \n";
	?>
	</style>
</head>
<body>
<img src="../pildid/vp_banner.png" alt="Veebiproge kursuse bänner" >
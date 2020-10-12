<?php
	require("../../../config.php");
	require("fnc_film.php");
	require("header.php");
?>
	<hr>
    <ul>
		<li><a href="uus.php">Avalehele</a></li>
		<li><a href="filmlisa.php">Filmiinfo lisamine</a></li>
	</ul>
	
	<hr>
	<?php echo readfilms(); ?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
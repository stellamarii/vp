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
	
	$notice = "";
	$filetype = "";
	$error = null;
	$filenameprefix = "vp_";
	$origphotodir = "../photoupload_orig/";
	$normalphotodir = "../photoupload_normal/";
	$maxphotowidth = 600;
	$maxphotoheight = 400;
	$filename = null;
	
	if(isset($_POST["photosubmit"])){
		//var_dump($_POST);
		//var_dump($_FILES);
		$check = getimagesize($_FILES["photoinput"]["tmp_name"]);
		if($check !== false){
			if($check["mime"] == "image/jpeg"){
				$filetype = "jpg";
			}
			if($check["mime"] == "image/png"){
				$filetype = "png";
			}
			if($check["mime"] == "image/gif"){
				$filetype = "gif";
			}
		} else {
			$error = "Valitud fail ei ole pilt!";
		}
		if($_FILES["photoinput"]["size"] > 10485760){
			$error .= " Fail ületab lubatud suuruse!";
		}
		$timestamp = microtime(1) *10000;
		$filename = $filenameprefix .$timestamp ."." .$filetype;
		if(file_exists($origphotodir .$filename)){
			$error .= " Sellise nimega fail on juba olemas!";
		}
		
		if(empty($error)){
			if($filetype == "jpg"){
				$mytempimg = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
			}
			if($filetype == "png"){
				$mytempimg = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
			}
			if($filetype == "gif"){
				$mytempimg = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
			}
			$imgw = imagesx($mytempimg);
			$imgh = imagesy($mytempimg);
			if($imgw/$maxphotowidth > $imgh/$maxphotoheight){
				$imgsizeratio = $imgw/$maxphotowidth;
			} else {
				$imgsizeratio = $imgh/$maxphotoheight;
			}
			
			$newphotow = round($imgw/$imgsizeratio);
			$newphotoh = round($imgh/$imgsizeratio);
			
			$mynewimg = imagecreatetruecolor($newphotow, $newphotoh);
			
			$transparentcolor = imagecolorallocatealpha($mynewimg, 0, 0, 0, 127);
			imagefill($mynewimg, 0, 0, $transparentcolor);
			
			imagecopyresampled($mynewimg, $mytempimg, 0, 0, 0, 0, $newphotow, $newphotoh, $imgw, $imgh);
			if($filetype == "jpg"){
				if(imagejpeg($mynewimg, $normalphotodir .$filename, 90)){
					$notice .= " Vähendatud pilt laeti edukalt üles!";
				} else {
					$notice .= " Vähendatud pildi üleslaadimisel tekkis tõrge!";
				}
			}
			if($filetype == "png"){
				if(imagepng($mynewimg, $normalphotodir .$filename, 6)){
					$notice .= " Vähendatud pilt laeti edukalt üles!";
				} else {
					$notice .= " Vähendatud pildi üleslaadimisel tekkis tõrge!";
				}
			}
			if($filetype == "gif"){
				if(imagegif($mynewimg, $normalphotodir .$filename)){
					$notice .= " Vähendatud pilt laeti edukalt üles!";
				} else {
					$notice .= " Vähendatud pildi üleslaadimisel tekkis tõrge!";
				}
			}
			
			if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $origphotodir .$filename)){
				$notice .= " Originaalfaili üleslaadimine õnestus!";
			} else {
				$notice .= " Originaalfaili üleslaadimisel tekkis tõrge!";
			}
		}
		
	}
	
	
	$failid = array_slice(scandir("../photoupload_normal/"), 2);
	$pildid = [];
	$pildiformaat = ["image/jpeg", "image/png"];
	foreach ($failid as $fail) {
		$failiformaat = getImagesize("../photoupload_normal/" .$fail);
		if(in_array($failiformaat["mime"], $pildiformaat) == true) {
			array_push($pildid, $fail);
		}
	}
	$pilte = count($pildid);
	$pilthtml = "";
	$pilthtml .= '<img src="../photoupload_normal/' .$pildid[mt_rand(0, ($pilte - 1))] .'" ';
	$pilthtml .= 'alt ="Üleslaetud pildid">';
	
	
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
	<h3>Siin saad pilte üles laadida!</h3>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<label for="photoinput">Vali pildifail: </label>
		<input id="photoinput" name="photoinput" type="file">
		<br>
		<label for="altinput">Sisesta pildi kirjeldus:</label>
		<br>
		<input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus...">
		<br>
		<label>Määra privaatsus:</label>
		<br>
		<input id="privinput1" name="privinput" type="radio" value="1">
		<label for="privinput1">Mulle näha</label>
		<input id="privinput2" name="privinput" type="radio" value="2">
		<label for="privinput2">Kasutajatele näha</label>
		<input id="privinput3" name="privinput" type="radio" value="3">
		<label for="privinput3">Kõigile näha</label>
		<br>
		<input type="submit" name="photosubmit" value="Lae pilt üles"><span><?php echo $notice; echo $error; ?></span>
	</form>

	<hr>
	<?php echo $pilthtml; ?>
	
	<hr>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
</body>
</html>
















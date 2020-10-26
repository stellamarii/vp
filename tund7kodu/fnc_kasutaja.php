<?php
	//session_start();
	
	$database = "if20_stella_3";
	
	function signup($enimi, $pnimi, $email, $sugu, $birthdate, $parool){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($parool, PASSWORD_BCRYPT, $options);
		
		$stmt->bind_param("sssiss", $enimi, $pnimi, $birthdate, $sugu, $email, $pwdhash);
		
		if($stmt->execute()){
			$notice = "ok";
		} else {
			$notice = $stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function signin($email, $parool){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT password FROM vpusers WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($paroolfromdb);
		if($stmt->execute()){
			//andmebaasi päring õnnestus
			if($stmt->fetch()){
				if(password_verify($parool, $paroolfromdb)){
					//mis kõik teha, kui saigi õige parooli, sisselogimine
					$notice = "ok";
					$stmt->close();
					
					$stmt = $conn->prepare("SELECT firstname, lastname, vpusers_id FROM vpusers WHERE email = ?");
					echo $conn->error;
					$stmt->bind_param("s", $email);
					$stmt->bind_result($eesnimifromdb, $perenimifromdb, $idfromdb);
					$stmt->execute();
					$stmt->fetch();
					$_SESSION["kasutajaid"] = $idfromdb;
					$_SESSION["kasutajaenimi"] = $eesnimifromdb;
					$_SESSION["kasutajapnimi"] = $perenimifromdb;
					$stmt->close();
					
					$stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid = ?");
					$stmt->bind_param("i", $_SESSION["kasutajaid"]);
					$stmt->bind_result($bgcolorfromdb, $txtcolorfromdb);
					$stmt->execute();
					if($stmt->fetch()){
						$_SESSION["txtcolor"] = $txtcolorfromdb;
						$_SESSION["bgcolor"] = $bgcolorfromdb;
					} else {
						$_SESSION["txtcolor"] = "#000000";
						$_SESSION["bgcolor"] = "#FFFFFF";
					}
					$stmt->close();
					
					$conn->close();
					header("Location: uus.php");
					exit();
				} else {
					$notice = "Vale salasõna!";
				}
			} else {
				$notice = "Sellist kasutajat (" .$email .") kahjuks pole!";
			}
		} else {
			$notice = "Sisselogimisel tekkis tehniline viga: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function storeuserprofile($description, $bgcolor, $txtcolor){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $conn->prepare("SELECT vpuserprofiles_id FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["kasutajaid"]);
		$stmt->execute();
		if($stmt->fetch()){
			$stmt->close(); //profiili uuendus
			$stmt=$conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			echo $conn->error;
			$stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["kasutajaid"]);
		} else {
			$stmt->close(); //profiili tegemine
			$stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $conn->error;
			$stmt->bind_param("isss", $_SESSION["kasutajaid"], $description, $bgcolor, $txtcolor);
		}
		
		if($stmt->execute()){
			$notice = "Profiil edukalt salvestatud!";
		} else {
			$notice = "Profiili salvestamine ebaõnnestus: " .$stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readdescription(){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		//vaatame, kas on profiil olemas
		$stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["kasutajaid"]);
		$stmt->bind_result($descriptionfromdb);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $descriptionfromdb;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>
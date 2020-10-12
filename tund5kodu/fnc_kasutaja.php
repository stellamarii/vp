<?php
	
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
?>
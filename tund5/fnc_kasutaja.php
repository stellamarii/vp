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
?>
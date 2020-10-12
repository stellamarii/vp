<?php
	$database = "if20_brianna_3";
	//var_dump($GLOBALS);
	
	function readfilms(){
		//loeme andmebaasist
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette SQL käsu
		//$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tooja, lavastaja FROM film");
		$stmt = $conn->prepare("SELECT * FROM film");
		echo $conn->error;
		//seome tulemuse mingi muutujaga
		$stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
		$stmt->execute();
		
		$filmshtml = "<ol> \n";
		//võtan, kuni on
		while($stmt->fetch()){
			//<p>suvaline mõte </p>
			$filmshtml .= "\t <li>" .$titlefromdb ."\n";
			$filmshtml .= "\t \t <ul> \n";
			$filmshtml .= "\t \t <li>Valmimisaasta: " .$yearfromdb ." </li> \n";
			$filmshtml .= "\t \t <li>Kestus: " .$durationfromdb ." minutit</li> \n";
			$filmshtml .= "\t \t <li>Žanr: " .$genrefromdb ." </li> \n";
			$filmshtml .= "\t \t <li>Stuudio: " .$studiofromdb ." </li> \n";
			$filmshtml .= "\t \t <li>Lavastaja: " .$directorfromdb ." </li> \n";
			$filmshtml .= "\t \t </ul> \n";
			$filmshtml .= "\t \t </li> \n";
		}
		$filmshtml .= "</ol>"; 
		$stmt->close();
		$conn->close();
		return $filmshtml;
		//ongi andmebaasist loetud
	}// readfilms() lõppeb siin
	
	function writefilm($title, $year, $duration, $genre, $studio, $director){
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("siisss", $title, $year, $duration, $genre, $studio, $director);
		$stmt->execute();
		
		$stmt->close();
		$conn->close();
	}
?>
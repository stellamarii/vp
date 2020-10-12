<?php
	$database = "if20_brianna_3";
	
	function filmdrop(){
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT movie_id, title FROM movie");
		echo $conn->error;
		$stmt->bind_result($filmidfromdb, $filmpealkirifromdb);
		$stmt->execute();
		$filmlist = "";
		while($stmt->fetch()){
			$filmlist .= "\n \t \t " .'<option value="' .$filmidfromdb .'">' .$filmpealkirifromdb .'<option>';
		}
		$stmt->close();
		$conn->close();
		return $filmlist;
	}
	
	function readstudiotoselect($selectedstudio){
		$notice = "<p>Kahjuks stuudioid ei leitud</p> \n";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT production_company_id, company_name FROM production_company");
		echo $conn->error;
		
		$stmt->bind_result($idfromdb, $companyfromdb);
		$stmt->execute();
		$studios = "";
		
		while($stmt->fetch()){
			$studios .= '<option value="' .$idfromdb .'"';
			if($idfromdb == $selectedstudio){
				$studios .= " selected";
			}
			$studios .= ">" .$companyfromdb .'<option>';
		}
		if(!empty($studios)){
			$notice = '<select name="filmstudioinput" id="filmstudioinput">' ."\n";
			$notice .= '<option value="" selected diasebled>Vali stuudio</option>' ."\n";
			$notice .= $studios;
			$notice .= "</select>";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readmovietoselect($selected){
		$notice = "<p>Kahjuks filme ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT movie_id, title FROM movie");
		echo $conn->error;
		$stmt->bind_result($idfromdb, $titlefromdb);
		$stmt->execute();
		$films = "";
		while($stmt->fetch()){
			$films .= '<option value="' .$idfromdb .'"';
			if(intval($idfromdb) == $selected){
				$films .=" selected";
			}
			$films .= ">" .$titlefromdb ."</option> \n";
		}
		if(!empty($films)){
			$notice = '<select name="filminput" id="filminput">' ."\n";
			$notice .= '<option value="" selected disabled>Vali film</option>' ."\n";
			$notice .= $films;
			$notice .= "</select> \n";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readgenretoselect($selected){
		$notice = "<p>Kahjuks žanre ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
		echo $conn->error;
		$stmt->bind_result($idfromdb, $genrefromdb);
		$stmt->execute();
		$genres = "";
		while($stmt->fetch()){
			$genres .= '<option value="' .$idfromdb .'"';
			if(intval($idfromdb) == $selected){
				$genres .=" selected";
			}
			$genres .= ">" .$genrefromdb ."</option> \n";
		}
		if(!empty($genres)){
			$notice = '<select name="filmgenreinput" id="filmgenreinput">' ."\n";
			$notice .= '<option value="" selected disabled>Vali žanr</option>' ."\n";
			$notice .= $genres;
			$notice .= "</select> \n";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function storenewstudiorelation($selectedfilm, $selectedstudio){
		$notice = "";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT movie_by_production_company_id FROM movie_by_production_company WHERE movie_movie_id = ? AND production_company_id = ?");
		echo $conn->error;
		$stmt->bind_param("ii", $selectedfilm, $selectedstudio);
		$stmt->bind_result($idfromdb);
		$stmt->execute();
		
		if($stmt->fetch()){
			$notice = " Selline seos on juba olemas!";
		} else {
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO movie_by_production_company (movie_movie_id, production_company_id) VALUES(?,?)");
			echo $conn->error;
			$stmt->bind_param("ii", $selectedfilm, $selectedstudio);
			if($stmt->execute()){
				$notice = " Uus seos edukalt salvestatud!";
			} else {
				$notice = " Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
			}
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readfromdb($sortby, $sortorder){
		$notice = "ei osanud :(";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		if($sortby == 0 and $sortorder == 0){
			$stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id");
		}
		if($sortby == 4){
			if($sortorder == 1){
				$stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id ORDER BY title");
			} else {
				$stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id ORDER BY title DESC");
			}
		}

		echo $conn->error;
		$stmt->bind_result($fnamefromdb, $lnamefromdb, $rolefromdb, $titlefromdb);
		$stmt->execute();
		$lines = "";
		while($stmt->fetch()){
			$lines .= "\t <tr> \n";
			$lines .= "\t <td>" .$fnamefromdb ."</td>";
			$lines .= "\t <td>" .$lnamefromdb ."</td>";
			$lines .= "\t <td>" .$rolefromdb ."</td>";
			$lines .= "\t <td>" .$titlefromdb ."</td>";
			"</tr> \n";
		}
		if(!empty($lines)){
			$notice = "<table> \n <tr> \n";
			$notice .= "<th>Eesnimi</th><th>Perekonnanimi</th><th>Roll</th>";
			$notice .= '<th>Film &nbsp; <a href="?sortby=4&sortorder=1">&uarr;</a> &nbsp; <a href="?sortby=4&sortorder=2">&darr;</a></th>' ."\n";
			$notice .= "</tr> \n";
			$notice .= $lines;
			$notice .= "</table>";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>
















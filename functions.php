<?php

	require("../../config.php");
	session_start();
	
	
	function signUp ($email, $password){
		$database = "if16_martkasa_eksam";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES(?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ss", $email, $password);
		if($stmt->execute()) {
			echo "salvestamine onnestus";
		} else {			
			echo "ERROR".$stmt->error;
		}		
		$stmt->close();
		$mysqli->close();
		
	}

	function login($email, $password) {
		$error="";
		$database = "if16_martkasa_eksam";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("SELECT id, email, password FROM user_sample WHERE email=?");
		echo $mysqli->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb,$passwordFromDb);
		$stmt->execute();
		
		if($stmt->fetch()){
			$hash=hash("sha512", $password);
			if($hash==$passwordFromDb){
				echo"Kasutaja logis sisse ".$id;				
				$_SESSION["userId"]=$id;
				$_SESSION["userEmail"]=$emailFromDb;
				header ("Location: data.php");
				}else {
				$error="vale parool";
			}
		}else{			
			$error="ei ole sellist emaili";			
		}		
		return $error;	
	}
		
		
	function savecontact ($firstname, $lastname, $number, $user) {
	$database = "if16_martkasa_eksam";		
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO contacts(eesnimi, perenimi, number, kasutaja) VALUES(?, ?, ?, ?)");
		echo $mysqli->error;		
		$stmt->bind_param("ssss", $firstname, $lastname, $number, $user);		
		if($stmt->execute()) {			
			echo "salvestamine 6nnestus";			
		} else {			
			echo "Mingi viga tuli".$stmt->error;
		}		
		$stmt->close();
		$mysqli->close();
		
	}	
		
		


?>
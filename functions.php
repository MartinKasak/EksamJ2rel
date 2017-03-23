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
		
	function getallcontacts($user, $q, $sort, $direction) {
		
		$allowedSortOptions=["eesnimi","perenimi","number"];
		if(!in_array($sort, $allowedSortOptions)){
			$sort = "eesnimi";
		}
		$orderBy="ASC";
		if($direction == "descending"){
			$orderBy="DESC";
		}
		
		$database = "if16_martkasa_eksam";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		if($q==""){
			
			$stmt=$mysqli->prepare("
			SELECT eesnimi, perenimi, number
			FROM contacts
			WHERE kasutaja = ?
			ORDER BY $sort $orderBy
		");
		
		$stmt->bind_param("s", $user);
		
		} else {
			
			$searchword="%".$q."%";
			$stmt=$mysqli->prepare("
			SELECT eesnimi, perenimi, number
			FROM contacts
			WHERE kasutaja = ? AND (eesnimi LIKE ? OR perenimi LIKE ? OR number LIKE ?)
			ORDER BY $sort $orderBy
		");
		
		$stmt->bind_param("ssss", $user, $searchword, $searchword, $searchword);
		}
		$stmt->bind_result($firstname, $lastname, $number);
		$stmt->execute();
		$result=array();
		while($stmt->fetch()) {
			$contact= new stdclass();
			$contact->firstname=$firstname;
			$contact->lastname=$lastname;
			$contact->number=$number;
			array_push($result, $contact);
		}
		$stmt->close();
		$mysqli->close();
		return $result;
	}	

	function getSingles($number){
		$database = "if16_martkasa_eksam";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("SELECT eesnimi, perenimi FROM contacts WHERE number=?");
		$stmt->bind_param("s", $number);
		$stmt->bind_result($eesnimi, $perenimi);
		$stmt->execute();
		$contact = new Stdclass();

		if($stmt->fetch()){
			$contact->number = $number;
			$contact->eesnimi = $eesnimi;
			$contact->perenimi = $perenimi;
		}else{
			header("Location: functions.php");
			exit();
		}
		$stmt->close();
		$mysqli->close();
		return $contact;	
	}
			
?>
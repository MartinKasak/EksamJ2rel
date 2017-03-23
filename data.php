<?php
	require("../../config.php");
	require("functions.php");
	
	if(!isset($_SESSION["userId"])){
		header("Location: loginpb.php");
	}

	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	
	}
	
	$user=$_SESSION["userEmail"];
	if(isset($_POST["firstname"]) && isset($_POST["lastname"]) &&	isset($_POST["number"]) &&
		!empty($_POST["firstname"]) && 		!empty($_POST["lastname"]) &&	!empty($_POST["number"])
		) {
		savecontact($_POST["firstname"], $_POST["lastname"], $_POST["number"], $user);
	}

	
?>
<html>
<h2>Tere tulemast</h2> 
<?=$_SESSION["userEmail"];?>
<br><br>
<a href="?logout=1">Logi valja</a>

	<h2>Salvesta uus kontakt</h2>
	<form method="POST">
		<label>Eesnimi</label><br>
		<input name="firstname" type="text" placeholder=""><br><br>
		<label>Perekonnanimi</label><br>
		<input name="lastname" type="text" placeholder=""><br><br>
		<label>Telefoni Number</label><br>
		<input name="number" type="integer" placeholder="">
		<br><br>
		<input type="submit" value="Salvesta">
	</form>
</html>



















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
	if(isset($_GET["sort"]) && isset($_GET["direction"])){
		$sort=$_GET["sort"];
		$direction=$_GET["direction"];
	}else{
		$sort="eesnimi";
		$direction="ascending";
	}
	if(isset($_GET["q"])){
		$q = $_GET["q"];
		$contactdata=getallcontacts($user, $q, $sort, $direction);
	}else{
		$q="";
		$contactdata=getallcontacts($user, $q, $sort, $direction);
	}
	
	
?>
<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
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

<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<h3>Inimese ja numbri otsimine </h3>
<form>
		<input type="search" name="q" value="<?=$q;?>">
		<input type="submit" value="Search"><br>
</form>
<h2>Telefonis olevad inimesed</h2>
</html>

<?php
	$direction="ascending";
	if(isset($_GET["direction"])){
		if($_GET["direction"] == "ascending"){
			$direction = "descending";
		}
	}
	$html = "<table border='0'>";
	
	$html .= "<tr>";
		$html .= "<th><a href='?q=".$q."&sort=eesnimi&direction=".$direction."'>Eesnimi</a></th>";
		$html .= "<th><a href='?q=".$q."&sort=perenimi&direction=".$direction."'>Perenimi</a></th>";
		$html .= "<th><a href='?q=".$q."&sort=number&direction=".$direction."'>Number</a></th>";
	$html .= "</tr>";
	
	foreach($contactdata as $c) {
		$html .= "<tr>";
			$html .= "<td>".$c->firstname."</td>";
			$html .= "<td>".$c->lastname."</td>";
			$html .= "<td>".$c->number."</td>";
			$html .= "<td><a href='edit.php?number=".$c->number."'>Edit</a></td>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	echo $html;


?>
		














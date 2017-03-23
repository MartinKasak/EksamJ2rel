<?php
	
	require("../../config.php");
	require("functions.php");
	
	if(isset($_POST["update"])){
		
		updateSingles($_POST["eesnimi"], $_POST["perenimi"], $_POST["number"], $_POST["newnumber"]);
		header("Location:data.php");
        exit();	
	}
	
	$c = getSingles($_GET["number"]);
?>

<h2>Muutmine</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" >
	<label for="number" >Number</label><br>
	<input type="hidden" name="number" value="<?=$_GET["number"];?>" > 
	<input id="newnumber" type="integer" name="newnumber" value="<?php echo $_GET["number"];?>" ><br><br>
  	<label for="eesnimi" >Eesnimi</label><br>
	<input id="eesnimi" name="eesnimi" type="text" value="<?php echo $c->eesnimi;?>" ><br><br>
  	<label for="perenimi" >Perekonnanimi</label><br>
	<input id="perenimi" name="perenimi" type="text" value="<?=$c->perenimi;?>"><br><br>
	<input type="submit" name="update" value="Salvesta">
</form>
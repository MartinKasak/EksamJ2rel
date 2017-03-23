<?php
	
	require("../../config.php");
	require("functions.php");
	$c = getSingles($_GET["number"]);
	
?>

<h2>Muutmine</h2>
	<label for="number" >Number</label><br>
	<input type="hidden" name="number" value="<?=$_GET["number"];?>" > 
	<input id="newnumber" type="integer" name="newnumber" value="<?php echo $_GET["number"];?>" ><br><br>
  	<label for="eesnimi" >Eesnimi</label><br>
	<input id="eesnimi" name="eesnimi" type="text" value="<?php echo $c->eesnimi;?>" ><br><br>
  	<label for="perenimi" >Perekonnanimi</label><br>
	<input id="perenimi" name="perenimi" type="text" value="<?=$c->perenimi;?>"><br><br>

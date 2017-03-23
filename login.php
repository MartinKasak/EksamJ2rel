<?php
	require("../../config.php");
	require("functions.php");

	
	$signupEmail = "";
	$signupEmailError= "";
	$signupPasswordError= "";
	$againPasswordError= "";

	$signinEmail= "";
	$signinEmailError= "";
	$signinPasswordError= "";
	

	//emaili lisamine
	if(isset($_POST["signupEmail"])){
		if(empty($_POST["signupEmail"])){
			$signupEmailError= "See vali on kohustuslik";
		}else{
			$signupEmail = $_POST["signupEmail"];
		}	
	}
	//salas6na lisamine
	if(isset($_POST["signupPassword"])){
		if(empty($_POST["signupPassword"])){
			$signupPasswordError= "See vali on kohustuslik";
		} else {
			if( strlen($_POST["signupPassword"]) <8 ){
				$signupPasswordError = "Parool peab olema vahemalt 8 tahemarki pikk";
			}
		}
	}
	//salas6na uuesti lisamine
	if(isset($_POST["againPassword"])){
		if($_POST["againPassword"] == $_POST["signupPassword"]){
			$againPasswordError= "";
		} else {
			$againPasswordError= "Parool ei olnud sama";
		}
	}
	//kui k6ik eelnev korras
	
	if(isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		$signupEmailError=="" &&
		$signupPasswordError=="") {
		$password = hash("sha512", $_POST["signupPassword"]);
		signUp($signupEmail, $password);
	}
	
	$error="";
	if(isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])
		) {
		login($_POST["loginEmail"], $_POST["loginPassword"]);
	}
	
	if(isset($_POST["loginEmail"])){
		if(empty($_POST["loginEmail"])){			
			$signinEmailError= "E-mail on puudu!";
		}else{
			$signinEmail = $_POST["loginEmail"];
		}
	}
	
	if(isset($_POST["loginPassword"])){
		if(empty($_POST["loginPassword"])){			
			$signinPasswordError= "Parool on sisestamata!";
		}
	}


?>

<h1>Logi sisse</h1>
<form method="POST">
	<?php if($error!=""){ echo $error;}?><br>
	
	<input name="loginEmail" placeholder="Kasutaja" type="text" value="<?=$signinEmail;?>"> <text><?php echo $signinEmailError; ?></text>
	<br><br>
	<input name="loginPassword" placeholder="Parool" type="password"> <text style="color:red;"><?php echo $signinPasswordError; ?></text>
	<br><br>
	<input type="submit" value="Logi Sisse">


</form>


<h1>Loo Kasutaja</h1>
<form method="POST">

	<b><label>Mail:</label></b><br>
	<input name="signupEmail" placeholder="mail@mail.com" type="text" value="<?=$signupEmail;?>"> <text style="color:red;"><?php echo $signupEmailError; ?></text>
	<br><br>
	<b><label>Parool:</label></b><br>
	<input name="signupPassword" placeholder="***************" type="password"> <text style="color:red;"><?php echo $signupPasswordError; ?></text>
	<br><br>
	<b><label>Parool uuesti:</label></b><br>
	<input name="againPassword" placeholder="**************" type="password"> <text style="color:red;"><?php echo $againPasswordError; ?></text>
	<br><br>
	<input type="submit" value="Loo Kasutaja">
	<br><br>
	
</form>
















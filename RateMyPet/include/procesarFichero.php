<?php
	session_start();

	if ($_SESSION["ownerOpet"]==="owner") {
		$savename=$_SESSION["username"];

		move_uploaded_file($_FILES["file"]["tmp_name"], "../usuarios/".$_FILES["file"]["name"]);
		if($_FILES["file"]["type"]==="image/png"){
			rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.png');
		}
		else if($_FILES["file"]["type"]==="image/jpg"){
			rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.jpg');
		}
		else echo "Image form error.";

	}
	
	header('Location: ../perfilOwner.php');
	exit();
?>
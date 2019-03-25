<?php
	require_once "config.php";
	require_once "Pet.php";

	$petName = isset($_POST['petName']) ? $_POST['petName'] : null;
	$petType = isset($_POST['petType']) ? $_POST['petType'] : null;
	$petBreed = isset($_POST['petBreed']) ? $_POST['petBreed'] : null;
	$petDescript = isset($_POST['petDescript']) ? $_POST['petDescript'] : null;
	$owner_id = isset($_SESSION['owner_id']) ? $_SESSION['owner_id'] : null;

	if(empty($petName) or empty($petType) or empty($petBreed) or empty($petDescript))	{
		//header("Location: ../errorRegistro.php");
		echo "Debes rellenar todos los campos";
	} else{

		$dir='../usuarios/'.$_SESSION["username"].'/'.$petName;
		if (is_dir($dir)) {
			echo "This pet already exists!";
		}
		else{
			$dir='../usuarios/'.$_SESSION["username"];
			if (is_dir($dir)===false) {
				mkdir($dir);
			}
			$petdir=$dir.'/'.$petName;
			mkdir($petdir);

			move_uploaded_file($_FILES["file"]["tmp_name"], $petdir.'/'.$_FILES["file"]["name"]);
/*
			if($_FILES["file"]["type"]==="image/png"){
				rename( $petdir.'/'.$_FILES["file"]["name"], $petdir.'/'.$petName.'.png');
			}
			else if($_FILES["file"]["type"]==="image/jpg"){
				rename( $petdir.'/'.$_FILES["file"]["name"], $petdir.'/'.$petName.'.jpg');
			}
			else echo "Image form error.";*/
		}

		$treats = 0;
		$pet = Pet::insertar($petName,$petType,$petBreed,$petDescript,$treats,$owner_id);
		header('Location: ../perfilOwner.php');
		exit();
	}

?>
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
		$treats = 0;
		$pet = Pet::insertar($petName,$petType,$petBreed,$petDescript,$treats,$owner_id);
		header('Location: ../perfilOwner.php');
		exit();
	}

?>
<?php

    require_once "Pet.php";

	 
		$petName = isset($_POST['pet']) ? $_POST['pet'] : null;
		$petType = isset($_POST['petType']) ? $_POST['petType'] : null;
		$petBreed = isset($_POST['petBreed']) ? $_POST['petBreed'] : null;
		$petDescript = isset($_POST['petDescript']) ? $_POST['petDescript'] : null;


		if(empty($pet)  or empty($petBreed) or empty($petDescript) or empty($petType))
			//header("Location: ../errorRegistro.php");
			echo "Debes rellenar todos los campos";

		else{
			$pet = Pet:: insertar($petName,$petType,$petBreed,$petDescript,0);
		 }
	

?>
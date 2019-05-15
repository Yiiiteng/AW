<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/Pet.php';
	require_once __DIR__.'/Usuario.php';

	$response = true;

	if (!$_SESSION['user']->giveTreat($_GET['idPet'])) {
		$response = false;
	} // Give the pet a treat
	
	if ($response) {
		header('Location: ../petProfile.php?idPet='.$_GET['idPet'].'&treat=true');
	} else {
		header('Location: ../petProfile.php?idPet='.$_GET['idPet'].'&treat=false');
	}
 	
?>
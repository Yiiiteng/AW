<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/Pet.php';

	// 1st: Find Pet

	$pet = Pet::buscarPet($_GET['idPet']);

	$numtreats = $pet->treats() + 1;
	$petId = $pet->petId();
	$sql = 'UPDATE pets SET treats = '.$numtreats.' WHERE idPet = '.$petId.'';

	$result = $conn->query($sql);
	header('Location: ../petProfile.php?idPet='.$petId.'');
?>
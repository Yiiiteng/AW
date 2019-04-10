<?php
	require_once __DIR__ . '/Aplicacion.php';
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/selectPet.php';

	$numtreats = $pet->$treats();
	$petId = $pet->$petId();
	$sql = 'UPDATE pets SET treats = '.$numtreats.'WHERE idPet='.$petId;
	$result = $conn->query($sql);
	header('Location: ../petProfile.php?idPet='.$petId.'');
?>
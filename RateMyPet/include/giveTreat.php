<?php
	require_once __DIR__ . '/Aplicacion.php';
	require_once __DIR__.'/config.php';

	$petId = $_GET['idPet'];
	$numtreats = $_GET['numtreat'];
	$numtreats++;
	$sql = "UPDATE pets SET treats = '$numtreats' WHERE idPet = '$petId'";
	$result = $conn->query($sql);
	
	header('Location: ../petProfile.php?idPet='.$petId.'');

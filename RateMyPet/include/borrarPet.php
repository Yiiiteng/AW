<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/Pet.php';

	$idowner = $_POST['id'];
	$pet = Pet::buscarPet($_GET['idpet']);
	$pet->borrarMascota();
	header('Location: ../petProfile.php?idPet='.$idowner.'');
?>
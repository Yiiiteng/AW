<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/Pet.php';

	$pet = Pet::buscarPet($_GET['idpet']);
	$idowner=$pet->owner_id();
	$pet->borrarMascota();
	header('Location: ../ownerProfile.php?id='.$idowner.'');
?>
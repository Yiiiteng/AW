<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/Pet.php';

	$idowner = $_GET['id'];
	$post = Pet::borrarPet($_GET['idpet']);
	header('Location: ../petProfile.php?idPet='.$idowner.'');
?>
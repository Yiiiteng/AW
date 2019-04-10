<?php
	require_once __DIR__.'/config.php';
	require_once __DIR__.'/Post.php';

	$petId = $_GET['idpet'];
	$post = Post::borrarPost($_GET['idpost']);
	header('Location: ../petProfile.php?idPet='.$petId.'');
?>
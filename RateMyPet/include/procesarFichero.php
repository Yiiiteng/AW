<?php
	require_once __DIR__.'/Usuario.php';
	session_start();

	$savename = $_SESSION['user']->username();

	unlink('../usuarios/'.$savename.'.jpg');
	unlink('../usuarios/'.$savename.'.png');

	move_uploaded_file($_FILES["file"]["tmp_name"], "../usuarios/".$_FILES["file"]["name"]);
	if($_FILES["file"]["type"]=="image/png"){
		rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.png');
	} else if($_FILES["file"]["type"]=="image/jpeg"){
		rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.jpg');
	} else if($_FILES["file"]["type"]=="image/jpg"){
		rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.jpg');
	} else echo "Image form error.";
	
	header('Location: ../ownerProfile.php?id='.$_SESSION['user']->id().'');
	exit();

?>
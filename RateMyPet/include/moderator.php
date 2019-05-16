<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Usuario.php';

$idUser = $_GET['id'];

if($_GET['act']=='Revoke'){
	Usuario::revokeMod($idUser);
}
else if($_GET['act']=='Give'){
	Usuario::giveMod($idUser);
}
else echo "someting wrong!";

header('Location: ../ownerProfile.php?id='.$idUser.'');
?>
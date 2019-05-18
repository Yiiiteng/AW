<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Post.php';   

    $you = $_SESSION['user']->verifiedPet($_GET['idPet']);

?>
<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';

    if ($_SESSION['user']->rol() != "admin") {
        header('Location: ../error.php');
    }

    $mods = Usuario::getMods();

?>
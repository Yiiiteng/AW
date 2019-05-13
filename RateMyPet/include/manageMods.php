<?php

    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';

    if ($_SESSION['user']->rol() != "admin") {
        header('Location: ../error.php');
    }

    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == "revoke") { // Revoke someone's mod priviledges
        Usuario::revokeMod($id);
    } else if ($action == "give") { // Add a new moderator
        Usuario::giveMod($id);
    } else {
        header('Location: ../error.php');
    }

    $previous = "javascript:history.go(-1)"; // Use the calling page as a return
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
        header('Location: '.$previous.'');
    } else {
        header('Location: ../adminOptions.php');
    }

?>
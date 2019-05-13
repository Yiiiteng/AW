<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';

    if (isset($_POST['type']) && isset($_POST['post'])) {
        if ($_POST['type'] == "like") { // Like the post
            $_SESSION['user']->repetPost($_POST['post']);
        } else { // Dislike the post
            $_SESSION['user']->unrepetPost($_POST['post']);
        }
    } else {
        header('Location: ../error.php');
    }
    header('Location: ../postMascota.php?id='.$_POST['post'].'');

?>
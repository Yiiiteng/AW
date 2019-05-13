<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';

    if (isset($_POST['type']) && isset($_POST['post']) && isset($_POST['idComment'])) {
        if ($_POST['type'] == "like") { // Like the post
            $_SESSION['user']->likeComment($_POST['post'], $_POST['idComment']);
        } else { // Dislike the post
            $_SESSION['user']->unlikeComment($_POST['post'], $_POST['idComment']);
        }
    } else {
        header('Location: ../error.php');
    }
    header('Location: ../postMascota.php?id='.$_POST['post'].'');

?>
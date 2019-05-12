<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Post.php';   

    echo ''.$_POST['postId'];

    if (isset($_POST['postId']) && $_SESSION['user']->isMod()) { // If user is a Moderator and POST exists
        $post = Post::buscaPost($_POST['postId']);
        $post->sign(); // Signed by the SESSION user
    }

    $previous = "javascript:history.go(-1)"; // Use the calling page as a return
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
        header('Location: '.$previous.'');
    } else {
        header('Location: ../adminOptions.php');
    }

?>
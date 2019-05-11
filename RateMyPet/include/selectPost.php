<?php
    $mod = false;
    $pending = false;
    $post = "";
    $postSimple = "";
    $signed = false;
    if (isset($_GET['id'])) { // Check who the requested post is
        $post = Post::buscaPost($_GET['id']);
        if(!$post) {
            header('Location: error.php');
        }
        $pending = $post->isPending();
        $mod = $_SESSION['user']->isMod() && isset($_SESSION['user']);
        if ($mod && $pending) { // Check if you signed the post
            $signed = $post->checkSigned($_SESSION['user']->id(), $_GET['id']);
        }
    } else { // You shouldn't be here
        header('Location: error.php');
    }
?>
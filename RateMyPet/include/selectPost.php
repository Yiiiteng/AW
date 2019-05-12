<?php
    $mod = false;
    $pending = false;
    $post = "";
    $postSimple = "";
    $signed = false;
    $me = "";
    $like = false;
    if (isset($_GET['id'])) { // Check who the requested post is
        $post = Post::buscaPost($_GET['id']);
        $pet = Pet::buscarPet($post->petid());
        $me = (Pet::buscarNombreDueño($pet->owner_id()) == $_SESSION['user']->username());
        if(!$post) {
            header('Location: error.php');
        }
        $pending = $post->isPending();
        $mod = $_SESSION['user']->isMod() && isset($_SESSION['user']);
        if ($mod && $pending) { // Check if you signed the post
            $signed = $post->checkSigned($_SESSION['user']->id(), $_GET['id']);
        }

        $like = $_SESSION['user']->checkLiked($_GET['id']); // Check if you've liked this post before
        $repet = $_SESSION['user']->checkRepeted($_GET['id']); // Check if you've reposted this post before
    } else { // You shouldn't be here
        header('Location: error.php');
    }
?>
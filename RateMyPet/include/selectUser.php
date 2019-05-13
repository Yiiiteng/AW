<?php
$me = false;
$user = "";
$myPets = "";
$following = false;

if (isset($_GET['id'])) { // Check who the requested user is
    $user = Usuario::buscaUsuarioId($_GET['id']);
    if(!$user) {
        echo 'No hay usuario con id = '.$_GET['id'].'';
        exit();
        header('Location: error.php');
    }
    if ($_SESSION['user']->id() == $user->id()) {  // This is me
        $me = true;
    } else { // Check if following
        $following = $_SESSION['user']->isFollowing($_GET['id']);
    }
    $myPets = Usuario::buscaMascotas($user);
} else { // You shouldn't be here
    header('Location: error.php');
}
?>
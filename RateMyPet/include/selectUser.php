<?php
$me = false;
$user = "";
$myPets = "";
$following = false;

if (isset($_GET['id'])) { // Check who the requested user is
    $sql = 'SELECT * FROM users WHERE id = '.$_GET['id']; // Return the user
    $data = $conn->query($sql);
    $user = $data->fetch_assoc();
    $user = Usuario::buscaUsuario($user['username']);
    if(!$user) {
        header('Location: error.php');
    }
    if ($_SESSION['user']->id() == $user->id()) {  // This is me
        $me = true;
    } else { // Check if following
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sqlFollowing = 'SELECT * FROM seguimientos WHERE userId ='.$_SESSION['user']->id().' AND seguidorId = '.$_GET['id'].''; // Return the user ID
        $result = $conn->query($sqlFollowing);
        $following = $result->num_rows ? true : false;
    }
    $myPets = Usuario::buscaMascotas($user);
} else { // You shouldn't be here
    header('Location: error.php');
}
?>
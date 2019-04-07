<?php
$me = false;
$user = "";
$myPets = "";

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
    }
    $myPets = Usuario::buscaMascotas($user);

    // Add the necessary values to User

    // Get number of followers
    // Get number of followed

} else { // You shouldn't be here
    header('Location: error.php');
}
?>
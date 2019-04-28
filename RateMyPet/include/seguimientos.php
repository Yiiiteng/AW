<?php

$followers = '';
$following = '';
$allUsers = '';
$pet = '';

if (isset($_GET['followersUsers'])) { // Check if it is the followers list
    $sqlFollowing = 'SELECT * FROM seguimientos WHERE seguidorId = '.$_GET['id']; // Return the user ID
    $following = $conn->query($sqlFollowing);
    $allUsers = array(); // Retrieve users that you are following
    if ($following->num_rows > 0) {   
        while($row = $following->fetch_assoc()) {
            $allUsers[] = Usuario::buscaUsuarioId($row['userId']);
        }        
    }
} else if (isset($_GET['followingUsers'])) { // Check if it is the followers list
    $sqlFollowers = 'SELECT * FROM seguimientos WHERE userId = '.$_GET['id']; // Return the user
    $followers = $conn->query($sqlFollowers);
    $allUsers = array(); // Retrieve users that you are following
    if ($followers->num_rows > 0) {   
        while($row = $followers->fetch_assoc()) {
            $allUsers[] = Usuario::buscaUsuarioId($row['seguidorId']);
        }        
    }
} else if (isset($_GET['followersPets'])) { // Check if it is the followers list
    $petId = $_GET['idPet'];
    $sqlFollowing = 'SELECT * FROM followedPets WHERE petId = '.$petId; // Return the user ID
    $following = $conn->query($sqlFollowing);
    $allUsers = array(); // Retrieve users that you are following
    if ($following->num_rows > 0) {   
        while($row = $following->fetch_assoc()) {
            $allUsers[] = Usuario::buscaUsuarioId($row['userId']);
        }
    }
    $pet = Pet::buscarPet($petId);
} else { 
    header('Location: ../error.php');
}
    
?>
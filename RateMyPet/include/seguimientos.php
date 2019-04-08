<?php

$followers = '';
$following = '';
$allUsers = '';

if (isset($_GET['followers'])) { // Check if it is the followers list
    $sqlFollowing = 'SELECT * FROM seguimientos WHERE seguidorId = '.$_GET['id']; // Return the user ID
    $following = $conn->query($sqlFollowing);
    $allUsers = array(); // Retrieve users that you are following
    if ($following->num_rows > 0) {   
        while($row = $following->fetch_assoc()) {
            $allUsers[] = Usuario::buscaUsuarioId($row['userId']);
        }        
    }
} elseif (isset($_GET['following'])) { // Check if it is the followers list
    $sqlFollowers = 'SELECT * FROM seguimientos WHERE userId = '.$_GET['id']; // Return the user
    $followers = $conn->query($sqlFollowers);
    $allUsers = array(); // Retrieve users that you are following
    if ($followers->num_rows > 0) {   
        while($row = $followers->fetch_assoc()) {
            $allUsers[] = Usuario::buscaUsuarioId($row['seguidorId']);
        }        
    }
}
    
?>
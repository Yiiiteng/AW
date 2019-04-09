<?php
    require_once __DIR__ . '/Aplicacion.php';

    $search = $_GET['search'];
    
    // Get all users that start withthe 3 first characters of search

    $control = Aplicacion::getSingleton();
    $conn = $control->conexionBd();

    $sql_users = 'SELECT * FROM users WHERE username LIKE \''.$search.'%\''; // Return owner id
    $sql_pets = 'SELECT * FROM pets WHERE name LIKE \''.$search.'%\''; // Return pet id
    
    $users = $conn->query($sql_users);
    $pets = $conn->query($sql_pets);

    if ($users->num_rows > 0) {
        $_SESSION['users'] = $users;
    } else {
        unset($_SESSION['users']);
    }

    if ($pets->num_rows > 0) {
        $_SESSION['pets'] = $pets;
    } else {
        unset($_SESSION['pets']);
    }

?>
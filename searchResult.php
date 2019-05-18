<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/search.php';
    require_once __DIR__.'/include/Usuario.php';
    require_once __DIR__.'/include/Pet.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="search-content" id="left">
        <h1>Owners</h1>
        <hr>
    <?php
        if (isset($_SESSION['users'])) {           
            $data = $_SESSION['users'];
            while($row = $data->fetch_assoc()) {
                echo ''.Usuario::toString($row); // Print User Format
            }
            echo 'Amount of Users found: '.$data->num_rows;
        } else {
            echo '<h2>No results</h2>';
        }
    ?>
    </div>
    <div class="search-content" id="right">
        <h1>Pets</h1>
        <hr>
    <?php
        if (isset($_SESSION['pets'])) {           
            $data = $_SESSION['pets'];
            while($row = $data->fetch_assoc()) {
                echo ''.Pet::toString($row); // Print User Format
            }
            echo 'Amount of Pets found: '.$data->num_rows;
        } else {
            echo '<h2>No results</h2>';
        }
    ?>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
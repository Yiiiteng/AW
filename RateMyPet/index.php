<?php
    require_once __DIR__.'/include/config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>RateMyPet</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="nav-bar">
        <ul>
            <li>
                <a href="addPet.php">Add a Pet</a>
            </li>
            <li>
                <a href="home.php">Home</a>
            </li>
            <li>
                <a href="perfilOwner.php">Owner Profile</a>
            </li>
            <li>
                <a href="">Hola</a>
            </li>
            <li>
                <a href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>   

    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
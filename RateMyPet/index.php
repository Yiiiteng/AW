<?php

    require_once __DIR__.'/include/config.php';
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>RateMyPet</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="header">
        <h1> Rate My Pet <h1>
    </div>

    <div class="nav-bar">
        <ul>
            <li>
                <a href="">Hola</a>
            </li>
            <li>
                <a href="">Hola</a>
            </li>
            <li>
                <a href="">Hola</a>
            </li>
            <li>
                <a href="">Hola</a>
            </li>
            <li>
                <a href="">Hola</a>
            </li>
        </ul>
    </div>


    <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            echo '<div class="content">
                <p>"Bienvenido de nuevo."<p>
            </div>';
        } else {
            echo '<div class="content">
                <p>"Esperemos que consideres crear una cuenta con nosotros."<p>
            </div>';
        }
    ?>

    <a href="logout.php">Log Out</a>

    

    <div class="footer">
        <h4>Made in UCM</h4>
    </div>
</body>
</html>
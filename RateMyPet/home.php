<?php

    require_once __DIR__.'/include/config.php';
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="header">
        <h1> Rate My Pet <h1>
    </div>

    <div class="nav-bar">
        <ul>
            <li>
                <a href="">Hola soy una home </a>
            </li>
            <li>
                <a href="profile.php">Perfil</a> <!--poner la url de perfil-->
            </li>
            <li>
                <a href="messages.php">Mensajes</a><!--poner la url a mensajes-->
            </li>
            <li>
                <a href="">Hola</a>
            </li>
            <li>
                <a href="logout.php">Logout</a><!--quiero moverlo a la derecha pero ni idea de como-->
            </li>
        </ul>
    </div>


    <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            echo '<div class="content">
                <p>Aqui estan todas las mascotas a las que sigues!<p>
            </div>';
        } else {
            header('Location: index.php');
            exit();
        }
    ?>


    <div class="footer">
        <h4>Made in UCM</h4>
    </div>
</body>
</html>
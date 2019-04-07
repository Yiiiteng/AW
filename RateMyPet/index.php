<?php
    require_once __DIR__.'/include/config.php';

   /* if (!isset($_SESSION['login']) && !$_SESSION['login'] === true) {
        header("Location: signup.php");
    }*/

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>This is your Home Page</h1>
        <p>Here you will be able to browse all of the new posts from your followed pets.</p>
        <img src="img/offline.png" alt="logo" id="centered-offline">
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/selectHome.php';
    require_once __DIR__.'/include/Post.php';
    

    if (!isset($_SESSION['login']) && !$_SESSION['login'] === true) {
        header("Location: signup.php");
    }

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
        <?php
        Post::displayHome($postList, 10);
        ?>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
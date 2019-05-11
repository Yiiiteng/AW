<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/modSetup.php';
    if (!$_SESSION["user"]->isMod()) {
        header('Location: error.php'); // If anyone tries to enter this page and is not a moderator
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>Moderator Options</h1>
        <h2>You are a moderator!</h2>
        <p>What does this mean? You have the priviledge to accept posts from other users.</p>
        <?php
            while ($row = $pending->fetch_assoc()) {
                $post = Post::buscaPost($row['idpost']);
                $pet = Pet::buscarPet($post->petid());
                echo '
                    <h1>Post from: '.$pet->petName().'</h1>';
                if (!$post->checkSigned($_SESSION['user']->id(), $post->idpost())) { // If you still haven't signed this petition
                    echo '<form action="postMascota.php" method="GET">
                            <input type="hidden" value="'.$post->idPost().'" name="id">
                            <input type="hidden" value="sign" name="sign">
                            <button type="submit">Sign</button>
                        </form>
                    ';
                } else {
                    echo '<h2>You have already signed the petition. Awaiting aproval from the other mods.</h2>';
                }
            }
        ?>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
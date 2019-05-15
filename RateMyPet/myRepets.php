<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/retrieveRepets.php';
    require_once __DIR__.'/include/Post.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>My repets</title>
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
        <h1>My Repet Posts</h1>
        <?php
            if (!$postList) { // You haven't liked any posts yet
                echo '<h2>You haven\'t repet any posts yet!</h2>';
            } else {
                while ($row = $postList->fetch_assoc()) {
                    $post = Post::buscaPost($row['idPost']);
                    $pet = Pet::buscarPet($post->petId());
                    echo '<div class="feed-post">';
                        echo '<div id="title">'; // Titlte of the post
                            echo '<h1>Post from: <a href="petProfile.php?idPet='.$pet->petId().'">'.$pet->petName().'</a></h1>';
                            echo '<h3>at: '.$post->time().'</h3>';
                            echo '<h2>Title: <a href="postMascota.php?id='.$post->idpost().'">'.$post->title().'</a></h2>';
                        echo '</div>';
                        echo '<div id="post">'; // Titlte of the post
                            echo ''.$post->description();
                        echo '</div>';
                    echo '</div>';
                }
            } 
        ?>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/retrievePosts.php';
    require_once __DIR__.'/include/Post.php';
    

    if (!isset($_SESSION['user'])) {
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
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>Your feed</h1>
        <?php
            // P.title, P.idpost, P.time, P.likes, P.repets, P.petid, P.description, pets.name
            if (!$postList) {
                echo '<h2>No new posts. Why not follow some pets?</h2>';
            } else {
                while ($row = $postList->fetch_assoc()) {
                    $post = Post::buscaPost($row['idpost']);
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
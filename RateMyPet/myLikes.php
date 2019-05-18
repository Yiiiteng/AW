<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/retrieveLikes.php';
    require_once __DIR__.'/include/Post.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>My likes</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/ranking.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css" />
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>My Liked Posts</h1>
        <?php
            if (!$postList) { // You haven't liked any posts yet
                echo '<h2>You haven\'t liked any posts yet!</h2>';
            } else {
                echo '<div class="multiple-items">';
                    while ($row = $postList->fetch_assoc()) {
                        $post = Post::buscaPost($row['idPost']);
                        $pet = Pet::buscarPet($post->petid());
                        echo '<div class="fourinline container card">';
                            echo '<h2>Post from: ' . $pet->petName() . '</h2>';
                            echo '<h3>at ' . $post->time() . '</h3>';
                            if (file_exists('upload/posts/' . $post->idPost() . '.png')) {
                                $path = 'upload/posts/' . $post->idPost() . '.png';
                            } else if (file_exists('upload/posts/' . $post->idPost() . '.jpg')) {
                                $path = 'upload/posts/' . $post->idPost() . '.jpg';
                            } else if (file_exists('upload/posts/' . $post->idPost() . '.jpeg')) {
                                $path = 'upload/posts/' . $post->idPost() . '.jpeg';
                            }
                            echo '<a href="postMascota.php?id=' . $post->idPost() . '"><img src="' . $path . '" style="width:100%" class="hover-opacity"></a>
                                    <div class="container white">
                                        <p>' . $post->title() . '</p>
                                        <p>' . $post->description() . '</p>
                                        <a href=""><p class="iright"><i class="fa fa-heart like"></i> ' . $post->likes() . '</p></a>
                                    </div>';
                        echo '</div';
                    }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
    <script type="text/javascript" src="js/slickSettings.js"></script>
</body>
</html>
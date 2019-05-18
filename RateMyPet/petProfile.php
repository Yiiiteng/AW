<?php
require_once __DIR__ . '/include/Usuario.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/selectPet.php';
require_once __DIR__ . '/include/Post.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Rate My Pet - profile</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/pet.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css" />
</head>

<body>
    <?php
    require("include/comun/header.php");
    ?>

    <div class="content">
        <h1>This is <?php echo '' . $pet->petName(); ?> the <?php echo '' . $pet->petType(); ?>'s Page</h1>
        <?php
        if (isset($_GET['treat'])) { // In case you gave him a treat
            if ($_GET['treat'] == "true") {
                $message = '' . $pet->petName() . ' looks happy... Thank you for the treat!';
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                $message = 'No treats left! Please wait a few minutes and try again.';
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }
        ?>

        <?php
        if ($mine) {
            echo '<p>Here you will be able to browse the pet\'s posts, as well as see everything related with the pet\'s ranking.</p>';
            echo '<h2>' . $pet->petName() . ' belongs to you!</h2>';
        } else {
            echo '<h2>This pet belongs to: <a href="ownerProfile.php?id=' . $pet->owner_id() . '">' . $name . '</a></h2>';
        }
        echo '<hr>';

        if (!$verified) { // Make the profile invisible for other users
            echo '<h1>'.$pet->petName().' is awaiting validation.</h1>';
            if ($_SESSION['user']->isMod() && $mine) {
                echo '<h1>Validate now!</h1>';
                echo '<form action="petTest.php" method="GET">'; // Like / dislike the post
                echo '<input type="hidden" name="idPet" value="' . $pet->petId() . '">';
                echo '<button type="submit" class="button-create" >Validate</button>';
                echo '</form>'; // Like / dislike the post
            }
        }
        ?>

        <?php

        ?>
        <div class="display-pets">
            <?php
            echo '<img class="pet-profile" src="' . $pet->getImageSrc() . '">';
            ?>
        </div>
        <?php
        echo '<p>' . $pet->petDescription() . '</p>';
        if (!$mine && $verified) {
            echo '<h4><a href="followers.php?idPet=' . $pet->petId() . '&followersPets">Followers:</a> ' . $pet->followerAmount() . '</h4>';
            if ($following) {
                echo '<form action="include/follow.php" method="POST">
                        <input type="hidden" name="id2" value="' . $pet->petId() . '">
                        <input type="hidden" name="action" value="unfollowPet">
                        <input class="button-create" type="submit" value="Unfollow">
                    </form>';
            } else {
                echo '<form action="include/follow.php" method="POST">
                        <input type="hidden" name="id2" value="' . $pet->petId() . '">
                        <input type="hidden" name="action" value="followPet">
                        <input class="button-create" type="submit" value="Follow">
                    </form>';
            }
        }

        if ($verified) {
            echo '<h4><a href="followers.php?idPet=' . $pet->petId() . '&followersPets">Followers:</a> ' . $pet->followerAmount() . '</h4>';
            echo '<h4><i class="fa fa-paw" id="treatNum"> ' . $pet->treats() . '</i></h4>';
            echo '<h4>Max Treats:  <i class="fa fa-paw" id="treatNum"> ' . $pet->topTreats() . '</i></h4>';
            echo '<h4>Max Rank: #' . $pet->maxRank() . '</i></h4>';
        }

        if (!$mine && $verified) {
            echo '
                <form method="post" action="include/giveTreat.php?idPet=' . $pet->petId() . '">
                    <input type="submit" class="button-create" value="Give a treat!">
                </form>
                ';
        } else if ($mine) {
            echo '<button type="button" class="button-create" onclick="window.location.href=\'updatePet.php?id=' . $pet->petId() . '\'">Edit</button>';
        }
        ?>
        <hr>
        <div class="pet-post">
            <?php
            if ($verified) {
            ?>
                <h3>Posts</h3>
                <form method="POST" action="petPost.php">
                    <input type="hidden" name="idPet" value="<?php echo $_GET['idPet']; ?>">
                <?php
                if ($mine) {
                    if ($verified) {
                        echo '<input class="button-create" type="submit" value="New Post">';
                    } else {
                        echo '<h1>'.$pet->petName().' needs to get verified before posting!</h1>';
                    }
                }
                ?>
            </form>
            <?php
                $myPosts = Post::allPosts($pet->petId());
                if ($myPosts->num_rows > 0) {
                    echo '<div class="multiple-items">';
                    while ($row = $myPosts->fetch_assoc()) {
                        $post = Post::buscaPost($row['idpost']);
                        echo '<div class="fourinline container card">';
                        if ($mine) { //  I can delete my post
                            echo '<form method="post" action="include/borrarPost.php?idpost=' . $post->idPost() . '&idpet=' . $pet->petId() . '">
                                            <button class="borrar fa-lg hover-opacity">
                                            <i class="fa fa-times-circle-o fa-lg"></i></button>
                                        </form>';
                        }
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
                                            <p class="iright"><i class="fa fa-heart like"></i>' . $post->likes() . '</p>
                                        </div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    if (!$mine) {
                        echo '<h1>This pet doesn\'t have any posts yet!</h1>';
                    }
                }
            }
            ?>
        </div>
    </div>
    <?php
    require("include/comun/footer.php");
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
    <script type="text/javascript" src="js/slickSettingsPosts.js"></script>
</body>

</html>
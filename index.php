<?php
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/retrievePosts.php';
require_once __DIR__ . '/include/Post.php';

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
    <link rel="stylesheet" href="css/ranking.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css" />
</head>

<body>
    <?php
    require('include/comun/header.php');
    ?>
    <div class="content">
        <a href="verifyPets.php">
            <h1>New pets want to be verified!</h1>
        </a>
        <hr>
        <h1>Posts from your followed pets:</h1>
        <?php
        // P.title, P.idpost, P.time, P.likes, P.repets, P.petid, P.description, pets.name
        if (!$postList) {
            echo '<h2>No new posts. Why not follow some pets?</h2>';
            echo '<div class="multiple-items">';
            while ($row = $ranking->fetch_assoc()) {
                echo '<div class="rank">';
                $owner = Usuario::buscaUsuarioId($row['owner_id']);
                $pet = Pet::buscarPet($row['idPet']);
                echo '<h1><a href="petProfile.php?idPet=' . $pet->petId() . '">' . $pet->petName() . '</h1>';
                echo '<img class="pet-pic" src="' . $pet->getImageSrc() . '"></a>';
                echo '<h3>' . $pet->treats() . ' <i class="fa fa-paw" aria-hidden="true"></i></h3>';
                echo '<h3>All Time Rank: # ' . $pet->maxRank() . '</h3>';
                echo '<h4>Highest amount of Treats: ' . $pet->topTreats() . '</h4>';
                echo 'Owned by: <a href="ownerProfile.php?id=' . $owner->id() . '">' . $owner->fullname() . '</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="multiple-items-feed">';
            while ($row = $postList->fetch_assoc()) {
                $post = Post::buscaPost($row['idpost']);
                $pet = Pet::buscarPet($row['petid']);
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
                echo '</div>';
            }
            echo '</div>';
            echo '<hr>';
            echo '<h1>Want an ever longer Time Line? Why not follow some more pets?</h1>';
            echo '<div class="multiple-items">';
            while ($row = $ranking->fetch_assoc()) {
                echo '<div class="rank">';
                $owner = Usuario::buscaUsuarioId($row['owner_id']);
                $pet = Pet::buscarPet($row['idPet']);
                echo '<h1><a href="petProfile.php?idPet=' . $pet->petId() . '">' . $pet->petName() . '</h1>';
                echo '<img class="pet-pic" src="' . $pet->getImageSrc() . '"></a>';
                echo '<h3>' . $pet->treats() . ' <i class="fa fa-paw" aria-hidden="true"></i></h3>';
                echo '<h3>All Time Rank: # ' . $pet->maxRank() . '</h3>';
                echo '<h4>Highest amount of Treats: ' . $pet->topTreats() . '</h4>';
                echo 'Owned by: <a href="ownerProfile.php?id=' . $owner->id() . '">' . $owner->fullname() . '</a>';
                echo '</div>';
            }
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
    <script type="text/javascript" src="js/slickSettingsRanking.js"></script>
    <script type="text/javascript" src="js/slickSettingsFeed.js"></script>
</body>

</html>
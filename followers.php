<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/Usuario.php';
    require_once __DIR__.'/include/Pet.php';
    require_once __DIR__.'/include/seguimientos.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/followers.css">
    <link rel="stylesheet" href="css/ranking.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css" />
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>

    <?php
    if (isset($_GET['followersUsers'])) { // Check if it is the followers list
        echo '<h1 class="follower">Followers</h1>';
    } else if (isset($_GET['followingUsers'])) { // Check if it is the following list
        echo '<h1 class="follower">Following</h1>';
    } 
    
    if (isset($_GET['followersPets'])) { // Check if it is the following list
        echo '<h1 class="follower">Followers</h1>';
        if (sizeof($allUsers) == 0) {
            echo '<h2 class="follower">Nobody loves '.$pet->petName().'! :(</h2>';
        } else {
            echo '<div class="multiple-items">';
            foreach ($allUsers as &$user) {
                echo '<div class="follower">';
                    echo '<h2><a href="ownerProfile.php?id='.$user->id().'">'.$user->username().'</h2>';
                    echo '<img class="follower-pic" src="'.$user->getImageSrc().'"></a>';
                echo '</div>';
            }
            echo '</div>';
        }
    } else {
        if (sizeof($allUsers) == 0) {
            echo '<h2 class="follower" >You don\'t have any followers!</h2>';
        } else {
            echo '<div class="multiple-items">';
            foreach ($allUsers as &$user) {
                echo '<div class="follower">';
                    echo '<h2><a href="ownerProfile.php?id='.$user->id().'">'.$user->username().'</h2>';
                    echo '<img class="follower-pic" src="'.$user->getImageSrc().'"></a>';
                echo '</div>';
            }
            echo '</div>';
        }
    }
    
    ?>

    <?php 
        require('include/comun/footer.php');
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
    <script type="text/javascript" src="js/slickSettings.js"></script>
</body>
</html>
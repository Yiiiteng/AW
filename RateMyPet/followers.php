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
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>

    <?php
    if (isset($_GET['followersUsers'])) { // Check if it is the followers list
        echo '<h1 class="follower">Followers</h1>';
        if (sizeof($allUsers) == 0) {
            echo '<h2 class="follower" >You don\'t have any followers!</h2>';
        } else {
            foreach ($allUsers as &$user) {
                echo '<h2 class="follower"><a href="ownerProfile.php?id='.$user->id().'">'.$user->username().'</a></h2>';
            }
        }
    } else if (isset($_GET['followingUsers'])) { // Check if it is the following list
        echo '<h1 class="follower">Following</h1>';
        if (sizeof($allUsers) == 0) {
            echo '<h2 class="follower">You don\'t follow anyone!</h2>';
        } else {
            foreach ($allUsers as &$user) {
                echo '<h2 class="follower"><a href="ownerProfile.php?id='.$user->id().'">'.$user->username().'</a></h2>';
            }
        }
    } else if (isset($_GET['followersPets'])) { // Check if it is the following list
        echo '<h1 class="follower">Followers</h1>';
        if (sizeof($allUsers) == 0) {
            echo '<h2 class="follower">Nobody follows you! :(</h2>';
        } else {
            foreach ($allUsers as &$user) {
                echo '<h2 class="follower"><a href="ownerProfile.php?id='.$user->id().'">'.$user->username().'</a></h2>';
            }
        }
    }
    ?>

    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
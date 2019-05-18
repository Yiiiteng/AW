<?php
require_once __DIR__ . '/include/config.php';

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
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <?php
    require('include/comun/header.php');
    ?>
    <div class="content">

        <?php
        if (isset($_GET['user'])) {
            echo '<h1>Are you sure you want to delete your account?</h1>
                <h2>Your pets will probably be very sad...</h2>
                <h2>All of your information, including pets, posts, and anything stored in our database will be deleted. You\'re welcome to come back any time!</h2>
                <div class="in-line">
                    <form method="POST" action="include/deleteAccount.php">
                        <input type="submit" class="button-create" value="Delete">
                    </form>
                    <form method="POST" action="ownerProfile.php?id=' . $_SESSION['user']->id() . '".php">
                        <input type="submit" class="button-create" value="Go Back">
                    </form>
                 </div>';
            }
            if (isset($_GET['pet'])) {
                $pet = Pet::buscarPet($_GET['pet']);
                echo '<h1>Are you sure you want to delete  ' .$pet->petName( ) .'\'s profile?</h1>
                <h2>But the fun was just getting started...</h2>
                <h2>All of ' .$pet->petName( ) .'\'s information, including posts, and anything stored in our database will be deleted.</h2>
                <div class="in-line">
                    <form method="POST" action="include/borrarPet.php">
                        <input type="submit" class="button-create" value="Delete">
                        <input type="hidden" name="id" value=" ' .$pet->petId( ) .'">
                    </form>
                    <form method="POST" action="ownerProfile.php?id= ' .$_SESSION['user']->id( ) .'".php">
                        <input type="submit" class="button-create" value="Go Back">
                    </form>
                </div>';
            }
            ?>


        </div>
        <?php
        require('include/comun/footer.php');
        ?>
    </body>

    </html>
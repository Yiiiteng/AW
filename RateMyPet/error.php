<?php
    require_once __DIR__.'/include/config.php';

    if (!isset($_SESSION['login']) && !$_SESSION['login'] === true) {
        header("Location: signup.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content-error">

        <?php
            if (isset($_SESSION['error'])) {
                switch($_SESSION['error']) {
                    case 'SearchError':
                        echo '<h1>No results...</h1>';
                    break;
                    default:
                        echo '<h1>Oops!</h1>
                        <p>Looks like there was a problem with your request!</p>
                        <p>Are you sure this is what you were looking for?</p>';
                    break;
                }   
            } else {
                echo '<h1>Oops!</h1>
                <p>Looks like there was a problem with your request!</p>
                <p>Are you sure this is what you were looking for?</p>';
            }
            unset($_SESSION['error']);
        ?>
        
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
$postList = false;
if (isset($_SESSION['user'])) { // if logged in
    $postList = $_SESSION['user']->getLikes();
} else { // You shouldn't be here
    echo 'Login or register :D';
}
?>
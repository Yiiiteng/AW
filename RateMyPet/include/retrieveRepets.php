<?php
require_once __DIR__.'/config.php';
$postList = false;

if (isset($_SESSION['user'])) { // if logged in
    $postList = $_SESSION['user']->getRepets();
} else { // You shouldn't be here
    echo 'Login or register :D';
}
?>
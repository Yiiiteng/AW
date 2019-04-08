<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/config.php';

$whoFollows = $_SESSION['user']->id(); 
$whoIsFollowed = $_GET['id2'];

// To unfollow, parse the option

$action = $_GET['action'];

if ($action == 'follow') {
    $sql = 'INSERT INTO seguimientos VALUES ('.$whoFollows.', '.$whoIsFollowed.')';
    $result = $conn->query($sql);
} else if ($action == 'unfollow') {
    // DELETE FROM `seguimientos` WHERE `seguimientos`.`userId` = 6 AND `seguimientos`.`seguidorId` = 8
    $sql = 'DELETE FROM seguimientos WHERE userId = '.$whoFollows.' AND seguidorId = '.$whoIsFollowed.'';
    $result = $conn->query($sql);
} else {
    header('Location: ../error.php');
}

header('Location: ../ownerProfile.php?id='.$whoIsFollowed.'');

?>
<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/config.php';

$whoFollows = $_SESSION['user']->id(); 
$whoIsFollowed = $_GET['id2'];

// To unfollow, parse the option

$action = $_GET['action'];

if ($action == 'followUser') {
    $sql = 'INSERT INTO seguimientos VALUES ('.$whoFollows.', '.$whoIsFollowed.')';
    $result = $conn->query($sql);
    header('Location: ../ownerProfile.php?id='.$whoIsFollowed.'');
} else if ($action == 'unfollowUser') {
    // DELETE FROM `seguimientos` WHERE `seguimientos`.`userId` = 6 AND `seguimientos`.`seguidorId` = 8
    $sql = 'DELETE FROM seguimientos WHERE userId = '.$whoFollows.' AND seguidorId = '.$whoIsFollowed.'';
    $result = $conn->query($sql);
    header('Location: ../ownerProfile.php?id='.$whoIsFollowed.'');
} else if ($action == 'followPet') { ///
    $sql = 'INSERT INTO followedPets VALUES ('.$whoFollows.', '.$whoIsFollowed.')';
    $result = $conn->query($sql);
    header('Location: ../petProfile.php?idPet='.$whoIsFollowed.'');

} else if ($action == 'unfollowPet') {
    // DELETE FROM `seguimientos` WHERE `seguimientos`.`userId` = 6 AND `seguimientos`.`seguidorId` = 8
    $sql = 'DELETE FROM followedPets WHERE userId = '.$whoFollows.' AND petId = '.$whoIsFollowed.'';
    $result = $conn->query($sql);
    header('Location: ../petProfile.php?idPet='.$whoIsFollowed.'');

} else {
    header('Location: ../error.php');
}

?>
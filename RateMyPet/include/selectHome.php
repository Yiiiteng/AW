<?php
require_once __DIR__.'/config.php';
$postList = array();

if (isset($_SESSION['username'])) { // if logged in
    $sql = 'SELECT P.idpost, P.time, P.likes, P.repets, P.petid, P.description, pets.name FROM followedpets FP join posts P on P.petId = FP.petId join pets on pets.idPet = P.petId WHERE '.$_SESSION['owner_id'].' = FP.userId ORDER BY P.time ASC'; // Return the user
    $postList = $conn->query($sql);
    //hacer esto luego $postList = $data->fetch_assoc();
    if(!$postList) {
        echo'you should try following someone';
    }
} else { // You shouldn't be here
    echo 'Login or register :D';
}
?>
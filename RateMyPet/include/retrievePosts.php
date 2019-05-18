<?php
require_once __DIR__.'/config.php';
$postList = false;
$ranking = "";

if (isset($_SESSION['user'])) { // if logged in
    $sql = 'SELECT P.title, P.idpost, P.time, P.likes, P.repets, P.petid, P.description, pets.name FROM followedpets FP join posts P on P.petId = FP.petId join pets on pets.idPet = P.petId WHERE '.$_SESSION['user']->id().' = FP.userId ORDER BY P.time DESC'; // Return the user
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        $postList = $rs;
    } 
    $ranking = false;

    $sql = 'SELECT P.idPet, P.treats, P.owner_id FROM pets P ORDER BY P.topTreats DESC LIMIT 10'; // Return ALL pets ranked
    $rs = $conn->query($sql);
    if($rs) {
        $ranking = $rs;
    }
} else { // You shouldn't be here
    echo 'Login or register :D';
}
?>
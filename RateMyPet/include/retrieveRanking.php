<?php
require_once __DIR__.'/config.php';
$ranking = false;

$sql = 'SELECT P.idPet, P.treats, P.owner_id FROM pets P ORDER BY P.treats DESC LIMIT 10 '; // Return the user
$rs = $conn->query($sql);
if($rs) {
    $ranking = $rs;
}
if (!isset($_SESSION['user'])) { // if logged in
   echo 'Being logged in is way more fun! Try it out!';
} 
?>
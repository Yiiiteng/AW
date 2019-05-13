<?php
$petID = $_GET['idPet'];
$pet = Pet::buscarPet($petID); // Search for requested Pet
$mine = ($pet->owner_id() == $_SESSION['user']->id() ? true : false);
$name = "";
$following = false;
if (!$mine) { // Give me the other owner's name
     $name = Pet::buscarNombreDueño($pet->owner_id());
     // Tell me if I follow him
     if ($_SESSION['user']->followsPet($petID)) {
        $following = true;
     }
}
if (!$pet) { // No pet with that id was found
    header('Location: error.php');
}
$verified = $pet->isVerified();
?>
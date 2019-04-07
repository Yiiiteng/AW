<?php
$petID = $_GET['idPet'];
$pet = Pet::buscarPet($petID); // Search for requested Pet
$mine = ($pet->owner_id() == $_SESSION['user']->id() ? true : false);
$name = "";
if (!$mine) { // Give me the other owner's name
     $name = Pet::buscarNombreDueño($pet->owner_id());
}
if (!$pet) { // No pet with that id was found
    header('Location: error.php');
}
?>
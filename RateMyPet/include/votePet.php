<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Pet.php';   

    $animal_A = $_POST['animal_A'];
    $animal_B_value = $_POST['animal_B'];
    $animal_B_name = $_POST['petType'];

    // The algorithm simply gets the value of the slider. If the first one is under 60%, that means the user is not confortable voting positive.
    // This functionality could be improved, but due to the lack of time, we decided to keep it simple.
    
    if ($animal_A <= 60) { // The user has decided that this pet is not what the owner says it is
        Pet::sayNo($_POST['petId']);
    } else {
        Pet::sayYes($_POST['petId']);
    }

    $previous = "javascript:history.go(-1)"; // Use the calling page as a return
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
        header('Location: '.$previous.'');
    } else {
        header('Location: ../adminOptions.php');
    }

?>
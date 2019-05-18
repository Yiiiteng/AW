<?php
    require_once __DIR__.'/config.php';
    $ranking = false;
    $top = false;

    $ranking = Pet::getRanking();
    $top = Pet::getTop();
?>
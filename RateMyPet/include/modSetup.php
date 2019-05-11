<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Post.php';

    $pending = Post::getPending();

?>
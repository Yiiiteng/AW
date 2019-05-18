<?php

// This script loads a list of Users that need to be verified

require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

$pets = Pet::getNotVerified(); // Return a list with all the users that need to be verified

?>
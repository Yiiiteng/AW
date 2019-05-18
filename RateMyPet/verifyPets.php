<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/loadPetsVerify.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ranking</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/ranking.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css"/>
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>These Pets need to get verified: </h1>
        <div class="multiple-items">
            <?php
                $counter = 0;
                while ($row = $pets->fetch_assoc()) {
                    echo '<div class="rank">';
                        $counter++;
                        $pet = Pet::buscarPet($row['idPet']);
                        echo '<h1>#'.$counter.' <a href="petTest.php?idPet='.$pet->petId().'">'.$pet->petName().'</h1>';
                        echo '<img class="pet-pic" src="'.$pet->getImageSrc().'"></a>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
	<script type="text/javascript" src="js/slickSettingsRanking.js"></script>
	<script type="text/javascript" src="js/slickSettingsTop.js"></script>
	<script type="text/javascript" src="js/timerRanking.js"></script>
</body>
</html>
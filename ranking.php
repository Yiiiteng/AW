<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/retrieveRanking.php';
    require_once __DIR__.'/include/Post.php';
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
        <div class="timer">
            <h1 class="title">Time until next contest:</h1>
            <h1 id="timer">0d 0h 0m 0s</h1>
            <p>
                When the timer hits 0, all the treats from all the pets will be reset to 0. The winner of the event will be rewarded with a Gold Medal.
            </p>
        </div>
        <hr>
        <h1>Current Ranking: </h1>
        <div class="multiple-items">
            <?php
                $counter = 0;
                while ($row = $ranking->fetch_assoc()) {
                    echo '<div class="rank">';
                        $counter++;
                        $owner = Usuario::buscaUsuarioId($row['owner_id']);
                        $pet = Pet::buscarPet($row['idPet']);
                        echo '<h1>#'.$counter.' <a href="petProfile.php?idPet='.$pet->petId().'">'.$pet->petName().'</h1>';
                        echo '<img class="pet-pic" src="'.$pet->getImageSrc().'"></a>';
                        if ($counter == 1) {
                            echo '<h1>🥇</h1>';
                        } else if ($counter == 2) {
                            echo '<h1>🥈</h1>';
                        } else if ($counter == 3) {
                            echo '<h1>🥉</h1>';
                        }
                        echo '<h3>'.$pet->treats().' <i class="fa fa-paw" aria-hidden="true"></i></h3>';
                        echo '<h3>All Time Rank: # '.$pet->maxRank().'</h3>';
                        echo '<h4>Highest amount of Treats: '.$pet->topTreats().'</h4>';
                        echo 'Owned by: <a href="ownerProfile.php?id='.$owner->id().'">'.$owner->fullname().'</a>';
                    echo '</div>';
                }
            ?>
        </div>
        <hr>
        <h1>All Time Rankings: </h1>
        <div class="multiple-items-top">
            <?php
                $counter = 0;
                while ($row = $top->fetch_assoc()) {
                    echo '<div class="rank">';
                        $counter++;
                        $owner = Usuario::buscaUsuarioId($row['owner_id']);
                        $pet = Pet::buscarPet($row['idPet']);
                        echo '<h1>#'.$counter.' <a href="petProfile.php?idPet='.$pet->petId().'">'.$pet->petName().'</h1>';
                        echo '<img class="pet-pic-2" src="'.$pet->getImageSrc().'"></a>';
                        if ($counter == 1) {
                            echo '<h1 class="medal">🥇</h1>';
                        } else if ($counter == 2) {
                            echo '<h1 class="medal">🥈</h1>';
                        } else if ($counter == 3) {
                            echo '<h1 class="medal">🥉</h1>';
                        }
                        echo '<h3>All Time Rank: # '.$pet->maxRank().'</h3>';
                        echo '<h4>Highest amount of Treats: '.$pet->topTreats().'</h4>';
                        echo 'Owned by: <a href="ownerProfile.php?id='.$owner->id().'">'.$owner->fullname().'</a>';
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
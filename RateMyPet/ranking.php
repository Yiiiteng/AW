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
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>Ranking</h1>
        <?php
            $counter = 0;
            while ($row = $ranking->fetch_assoc()) {
                $counter++;
                $owner = Usuario::buscaUsuarioId($row['owner_id']);
                $pet = Pet::buscarPet($row['idPet']);
                echo '<h1>'.$counter.':<a href="petProfile.php?idPet='.$pet->petId().'">'.$pet->petName().'</a></h1>';
                echo '<h3>'.$pet->treats().' <i class="fa fa-paw" aria-hidden="true"></i></h3>';
                echo 'Owned by: <a href="ownerProfile.php?id='.$owner->id().'">'.$owner->fullname().'</a>';
            }
        ?>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>
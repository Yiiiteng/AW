<?php
    require_once __DIR__.'/include/Usuario.php';
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/Pet.php';
    
    $petID = $_GET['idPet'];
    $idOwner = $_SESSION['owner_id'];

    $isYours = Pet::existePet($idOwner,$petID);

    if ($isYours) {
        $result = Pet::buscarPet($petID);
    }
    else{
        $result = Pet::buscarPet($petID);
        $otherUserid = $result->petOwnerId();
        $otherUser = Usuario::buscaUsuariowithID($otherUserid);
    }
    $petName = $result->petName();
    $petType = $result->petType();
    $petBreed = $result->petBreed();
    $petDesc = $result->petDescript();
    $pettreat = $result->treats();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Rate My Pet - profile</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
	<?php
		require("include/comun/header.php");
    ?>
    
    <div class="content">
        <h1>This is <?php echo ''.$petName; ?> the <?php echo ''.$petType; ?>'s Page</h1>
        <p>Here you will be able to browse the pet's posts, as well as see everything related with the pet's ranking.</p>
        
        <?php 
            if ($isYours) {
                echo '<h2>I belong to you!</h2>';
            } else {
                echo '<h2>This pet belongs to: <a href="userProfile.php?id='.$otherUserid.'">'.$otherUser->username().'</a></h2>';
            }
        ?>
        <div class="display-pets">
            <img src="img/animals/<?php echo $petType?>.png"></a>
        </div>
        <?php
            echo '<p>'.$petDesc.'</p>';
        ?>
        <h4>Followers: 324 | Following: 30</h4>

        <?php
            if (!$isYours){
        ?>
            <button type="button" class="button-create" onclick="window.location.href='/RateMyPet/FoemularioFollow.php'"> FOLLOW! </button>
            <i class="fa fa-paw" id="treatNum"> <?php echo $pettreat; ?></i>
            <button type="button" id="giveTreat" class="button-create"> Give a treat! </button>
            
            <div class="pet-post">
                <h2>POST</h2>
        <?php
            
            }
            else{
        ?>
            <div class="pet-post">
                <h2>POST</h2>
                <button type="button" class="button-create" onclick="window.location.href='petPost.php'">New Post</button>
                
        <?php 
            }
        ?>
            </div>
	</div>

    <script>
        document.getElementById("giveTreat").addEventListener("click", GiveTreat);

        function GiveTreat(){
            var pettreat = <?php echo $pettreat ?>;
            pettreat++;
            
            document.getElementById("treatNum").innerHTML = pettreat;
        }
    </script>

    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>
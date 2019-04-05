<?php
    require_once __DIR__.'/include/config.php';
    
    $pet = $_GET['idPet'];

    $control = Aplicacion::getSingleton();
    $conn = $control->conexionBd();
    $sql = sprintf("SELECT * FROM pets WHERE idPet = '%s'", $pet); // Return owner id
    $result = $conn->query($sql);

    $petName = "";
    $petID = "";
    $petType = "";
    $isYours = false;
    $petDesc ="";
    $pettreat ="";
    $petOwnerId ="";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $petName = $row['name'];
            $petID = $pet;
            $petType = $row['type'];
            $petDesc = $row['description'];
            $pettreat = $row['treats'];
            $petOwnerId = $row['owner_id'];
            $idYours = $_SESSION['owner_id'];
            if ($idYours == $petOwnerId) $isYours = true;
        }
    } else {
        header("Location: error.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Rate My Pet - profile</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                echo '<h2>Hello! My owner isn\'t home. Why not leave him a message?</h2>';
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
        <?php
            
            }
        ?>

        <div class="pet-post">
            <h2>POST</h2>
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
		//require("include/comun/footer.php");
	?>
</body>
</html>
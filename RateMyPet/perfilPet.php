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

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $petName = $row['name'];
            $petID = $pet;
            $petType = $row['type'];
            if ($_SESSION['owner_id'] == $row['owner_id']) $isYours = true;
        }
    } else {
        header("Location: error.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Rate My Pet - perfil</title>
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
                echo '<h2>Hello! My owner isn\'t home. Why not leave him a message?</h2>';
            }
        ?>
        <div class="display-pets">
            <img src="img/animals/<?php echo $petType?>.png"></a>
		</div>
	</div>
    
    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>
<?php
    require_once __DIR__.'/include/config.php';
    
    $pet = $_GET['idPet'];

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

    <div>
        <?php
            $control = Aplicacion::getSingleton();
            $conn = $control->conexionBd();
            $sql = sprintf("SELECT * FROM pets WHERE idPet = '%s'", $pet); // Return owner id
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo 'Hello, I am your pet: ' .$row['name'];
                }
            } else {
                echo 'This pet doesn\'t exist';
                // header("Location: index.php");
            }
        ?>
    </div>

    
    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>
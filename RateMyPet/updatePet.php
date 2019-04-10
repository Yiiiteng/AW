<?php
	require_once __DIR__.'/include/Aplicacion.php';
	require_once __DIR__.'/include/config.php';
	require_once __DIR__.'/include/FormularioPet.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rate My Pet: update pet</title>
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
	<?php
		require("include/comun/header.php");
    ?>
	<div>
		<?php
			$opciones = array(); // Ninguna por defecto
			$formulario = new FormularioEditPet("EditPet",$opciones); // Créame una instancia hija de Form de tipo FormularioPet
			$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Añadir Pet
		?>
	<div>
	<?php
		require("include/comun/footer.php");
    ?>
</body>
</html>

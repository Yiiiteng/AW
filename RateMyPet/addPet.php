<?php
	require_once __DIR__.'/include/Aplicacion.php';
	require_once __DIR__.'/include/config.php';
	require_once __DIR__.'/include/FormularioPet.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rate My Pet: Add your pet</title>
	<link rel="stylesheet" type="text/css" href="css/perfil.css">
</head>

<body class="color-fondo">
	<div>
		<?php
			$opciones = array(); // Ninguna por defecto
			$formulario = new FormularioPet("Pet", $opciones); // Créame una instancia hija de Form de tipo FormularioPet
			$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Añadir Pet
		?>
	</div>
</body>
</html>

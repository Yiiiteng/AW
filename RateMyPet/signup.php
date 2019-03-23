<?php
	require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/FormularioLogin.php';
    require_once __DIR__.'/include/FormularioRegistro.php';

    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>RateMyPet</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="header">
        <h1>RateMyPet</h1>
        <img src="img/logo-cabecera.png" alt="RateMyPet">
    </div>

    <div class="split left">
        <div class="centered">
            <?php
				$opciones = array(); // Ninguna por defecto
				$formulario = new FormularioLogin("Login", $opciones); // Créame una instancia hija de Form de tipo FormularioLogin
				$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Login
			?>
        </div>
    </div>

    <div class="split right">
        <div class="centered">
            <?php
				$opciones = array(); // Ninguna por defecto
				$formulario = new FormularioRegistro("Register", $opciones); // Créame una instancia hija de Form de tipo FormularioLogin
				$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Login
			?>
        </div>
    </div>

    <div class="footer">
        <h1>Not convinced? <a href="index.php">Browse our website!</a></h1>
    </div>
</body>
</html>
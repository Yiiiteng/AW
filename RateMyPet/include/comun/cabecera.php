<div id="cabecera">
<!--includes/comun-->
	<h1><img src="img/logo.png" alt="Logo" width="70" height="70" /><a href= "index.php">Rate My Pet</a></h1>

	<?php
	if (isset($_SESSION["LogIn"]) && ($_SESSION["LogIn"]===true)) {
	?>

	<?php
	}
	 else {
	?>
		<div class="saludo">Usuario desconocido. 
			<a href='login.php'>Login</a> <a href='registro.php'> Registrarse</a>
		</div>
		<?php
	}
	?>
</div>















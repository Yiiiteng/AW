<div class="header">
<!--includes/comun-->
	<h1>
		<img src="img/logo.png" alt="Logo" width="70" height="70" />
			<a href= "index.php">Rate My Pet</a>
	</h1>

	<?php
		if (isset($_SESSION["username"]) && ($_SESSION["login"]===true)) {
	?>
		<div class="saludo">Welcome back, <?php
			echo ' ' . $_SESSION["username"] . ' ' . '<a href="logout.php" class="button-create">Logout</a>'
		?>
		
	<?php
	}
	 else {
	?>
		<div class="saludo">Unknown user.  
			<a href='signup.php' class="button-create">Login/Register</a>
		</div>
		<?php
	}
	?>
</div>















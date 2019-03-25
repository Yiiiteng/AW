<div class="header">
	<title_>
		<a href= "index.php">Rate My Pet</a>
	</title_>
	<nav>
        <a href="perfilOwner.php">Owner Profile</a>
		<?php
		if (isset($_SESSION["username"]) && ($_SESSION["login"]===true)) {
			echo '<a class="hello" href="logout.php" class="button-create">Logout</a>';
		} else {
			echo '<a class="hello" href="signup.php" class="button-create">Login/Registrarse</a>';
		}
	?>
	</nav>
</div>















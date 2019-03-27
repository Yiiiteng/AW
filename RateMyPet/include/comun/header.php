<div class="header">
	<div>
	<a href="index.php"><img src="img/logo-header.png" alt="logo" class="logo"></a>
	</div>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="perfilOwner.php">Profile</a></li>
		</ul>
	</nav>
	<nav id="log">
		<ul>
			<li><?php
			if (isset($_SESSION["username"]) && ($_SESSION["login"]===true)) {
				echo '<a href="logout.php">Logout</a>';
			} else {
				echo '<a href="signup.php">Login/Register</a>';
			}
			?></a></li>
		</ul>
	</nav>
</div>















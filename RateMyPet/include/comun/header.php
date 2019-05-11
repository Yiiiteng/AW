<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="header">
	<div>
	<a href="index.php"><img src="img/logo-header.png" alt="logo" class="logo"></a>
	</div>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<?php
				echo '<li><a href="ownerProfile.php?id='.$_SESSION["user"]->id().'">Profile</a></li>';
				if ($_SESSION["user"]->rol() == "admin") {
					echo '<li><a href="adminOptions.php">Admin Options</a></li>';
				}
				if ($_SESSION["user"]->isMod()) {
					echo '<li><a href="moderatorOptions.php">Moderator Options</a></li>';
				}
			?>
			<li>
				<div class="bar1"> 
					<form method="GET" action="searchResult.php">
						<input type="search" id="search" name="search" placeholder="Search...">
						<button type="submit"></button>
					</form>
				</div>
			<li>
		</ul>
	</nav>
	<nav id="log">
		<ul>
			<li><?php
			if (isset($_SESSION["username"]) && ($_SESSION["login"]===true)) {
				echo '<a href="logoutConfirm.php">Logout</a>';
			} else {
				echo '<a href="signup.php">Login/Register</a>';
			}
			?></a></li>
		</ul>
	</nav>
</div>

<?php
	require_once __DIR__.'/include/config.php';
	
	$control = Aplicacion::getSingleton();
	$conn = $control->conexionBd();
	$sql = sprintf("SELECT * FROM pets WHERE owner_id = '%s'", $_SESSION['owner_id']); // Return owner id
	$myPets = $conn->query($sql); // List of my pets (If I have any)
		
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
	<?php
		require("include/comun/header.php");
	?>

	<div>

	<div class="content">
        <h1>This is your Profile Page</h1>
		<p>Here you will be able to select any of your pet accounts, add a new pet, change your profile settings...</p>
		
		<?php
			$_SESSION["ownerOpet"]="owner";

			$path='usuarios/'.$_SESSION["username"].'.jpg';
			if (file_exists('usuarios/'.$_SESSION["username"].'.jpg')) {
				echo '<img src='.$path.' alt="Logo" width="100" height="100" />';
			}
			else{
				echo '<img src="usuarios/default.png" alt="Logo" width="100" height="100" />';
			}
		?>

		<form class="file" action="include/procesarFichero.php" method="POST" enctype="multipart/form-data">
			Change foto(jpg/png): 
			<input type="file" name="file" accept="image/*" id="upload" >
			<input type="submit" value="Change">
		</form>  

		<h1>These are your parameters:</h1>

		<table>
		<?php
			echo "<tr>
			<th> Name: ".$_SESSION['username']."</th>
			</tr>
			<tr>
			<th> Email: ".$_SESSION['email']."</th>
			</tr>";
		?>
		<tr>
		<!--echo $_SESSION['followed']; need add a function-->
		<th>Followers: 48</th>
		</tr>
		<tr>
		<!--echo $_SESSION['followed']; need add a function-->
		<th>Following: 49</th>
		</tr>
		<tr>
		<!--echo $_SESSION['weekrank'];-->
		<th>Current Weekly Rank: #302</th>
		</tr>
		<tr>
		<!--echo $_SESSION['bestrank'];-->
		<th>Best Weekly Rank: #3</th>
		</tr>
		</table>

		<h3>My pets</h3>
		<div class="display-pets">
			<ul>
				<?php
				if ($myPets->num_rows > 0) { // Iterate through all of my pets
					while($pet = $myPets->fetch_assoc()) {
						echo '<li><div class="image">
								<a href="perfilPet.php?idPet='.$pet['idPet'].'">
								<img src="img/animals/'.$pet['type'].'.png">
								</a>
								'.$pet['name'].'
						</div></li>';
					}
				} else {
					echo "You don't own any pets!";
				}
				?>
			</ul>
		</div>
		</br>
		<button type="button" id="button-add-pet" onclick="window.location.href='addPet.php'"> Add a Pet </button>
	</div>

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>
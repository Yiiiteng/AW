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
	<title>Rate My Pet - profile</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
	<?php
		require("include/comun/header.php");
	?>

	<div class="content">
        <h1>This is your Profile Page</h1>
		<p>Here you will be able to select any of your pet accounts, add a new pet, change your profile settings...</p>
		
		<?php
			$_SESSION["ownerOpet"]="owner";

			$path='usuarios/'.$_SESSION["username"];
			if (file_exists('usuarios/'.$_SESSION["username"].'.jpg')) {
				echo '<img src='.$path.'.jpg alt="Logo" width="100" height="100" />';
			}
			else if (file_exists('usuarios/'.$_SESSION["username"].'.png')) {
				echo '<img src='.$path.'.png alt="Logo" width="100" height="100" />';
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

		<h1>My info:</h1>

		<table id="info">
		<?php
			echo "
			<tr>
				<td> Name: </td> <td>".$_SESSION['username']."</td>
			</tr>
			<tr>
				<td> Email: </td> <td>".$_SESSION['email']."</td>
			</tr>";
		?>
		<tr>
		<!--echo $_SESSION['followed']; need add a function-->
			<td>Followers: </td> <td>48</td>
		</tr>
		<tr>
		<!--echo $_SESSION['followed']; need add a function-->
			<td>Following: </td> <td>49</td>
		</tr>
		<tr>
		<!--echo $_SESSION['weekrank'];-->
			<td>Current Weekly Rank: </td> <td>#302</td>
		</tr>
		<tr>
		<!--echo $_SESSION['bestrank'];-->
			<td>Best Weekly Rank: </td> <td>#3</td>
		</tr>
		</table>

		<h1>My pets</h1>
		<div class="display-pets">
			<ul>
				<?php
				if ($myPets->num_rows > 0) { // Iterate through all of my pets
					while($pet = $myPets->fetch_assoc()) {
						echo '<li><div class="image">
								<a href="petProfile.php?idPet='.$pet['idPet'].'">
								<img src="img/animals/'.$pet['type'].'.png">
								</a>
								'.$pet['name'].'
						</div></li>';
					}
				} else {
					echo "<h2>You don't own any pets!</h2>";
				}
				?>
			</ul>
		</div>
		<button type="button" class="button-create" onclick="window.location.href='/RateMyPet/addPet.php'"> Add a Pet </button>
	</div>

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>
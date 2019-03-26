<?php
	require_once __DIR__.'/include/config.php';
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

		<table id="info">
		<?php
			echo "<tr>
			<th> ".$_SESSION['username']."</th>
			</tr>
			<tr>
			<th>".$_SESSION['email']."</th>
			</tr>";
		?>
		<tr>
		<!--echo $_SESSION['followed']; need add a function-->
		<th>48 seguidores</th>
		</tr>
		</table>


		<table>
		<tr>
		<!--echo $_SESSION['weekrank'];-->
		<th>Current Weekly Rank: #302</th>
		</tr>
		<tr>
		<!--echo $_SESSION['bestrank'];-->
		<th>Best Weekly Rank: #3</th>
		</tr>
		</table>

		<div class="card" id="myPet">
		<h3>My pets</h3>
		<?php
		$control = Aplicacion::getSingleton();
		$conn = $control->conexionBd();
		$sql = sprintf("SELECT * FROM pets WHERE owner_id = '%s'", $_SESSION['owner_id']); // Return owner id
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				//$dir="usuarios/". $_SESSION['username']."/".$row['name']."/".$row['name'].".png";
				//echo 'Owner of: ' .$row["idPet"] .'<img src='.$dir.' alt="petFoto" width="100" height="100" />';
				$pet = $row["idPet"];
				echo '<a href="perfilPet.php?idPet='.$pet.'"><img src="img/Adrian.jpg">Go To Profile of '.$row['name'].'</a><br/>';
				/*echo '<form method="post" action="perfilPet.php">
				<input type="hidden" name="idPet" value='.$row["idPet"].'>
				<input type="submit">
				<label>Go to '.$row['name'].'\'s  Profile</label>
				</form>';*/
			}
		} else {
			echo "You don't own any pets!";
		}

		?>
		<button type="button" id="button-add-pet" onclick="window.location.href='addPet.php'"> + </button>
	</div>

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>
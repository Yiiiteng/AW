<?php
	require_once __DIR__.'/include/Usuario.php';
	require_once __DIR__.'/include/Pet.php';
    require_once __DIR__.'/include/config.php';
    
	$user = Usuario::buscaUsuario($_SESSION['username']);
	$userid = Usuario::buscaIdUsuario($_SESSION['username']);
	$num = Pet::numPets($userid['id']);
	$myPets = Pet::allPets($userid['id']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Rate My Pet - profile</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
	<?php
		require("include/comun/header.php");
	?>

	<div class="content"> 
		<div id="image">
		<?php
		
			$_SESSION["ownerOpet"]="owner";

			$path='usuarios/'.$_SESSION["username"];
			if (file_exists('usuarios/'.$_SESSION["username"].'.jpg')) {
				echo '<img src='.$path.'.jpg alt="Logo" width="150" height="150" />';
			}
			else if (file_exists('usuarios/'.$_SESSION["username"].'.png')) {
				echo '<img src='.$path.'.png alt="Logo" width="150" height="150" />';
			}
			else{
				echo '<img src="usuarios/default.png" alt="Logo" width="150" height="150" />';
			}
		?> 
		</div>



		<table id="info">
			<?php
				echo "
				<tr>
					 <td>".$_SESSION['username']."</td>
				</tr>
				<tr>
					 <td>".$_SESSION['email']."</td>
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
				<td><button type="button" id="button-follow"> Follow </button> </td>
			</tr>

		</table>
		
		<div id="rankingPerfil">
			<table>
			<tr>
			<!--echo $_SESSION['weekrank'];-->
				<td>Current Weekly Rank: </td> <td>#302</td>
			</tr>
			<tr>
			<!--echo $_SESSION['bestrank'];-->
				<td>Best Weekly Rank: </td> <td>#3</td>
			</tr>
		</table>	
		</div>

	
		<div class="display-pets">
			<?php echo '<h1>'.$user->username().'\' pets: </h1>'; ?> 
			<ul>
				<?php

				if ($num > 0) { // Iterate through all of my pets
					foreach($myPets as $item => $pet) {
						echo '<li><div class="image">
								<a href="petProfile.php?idPet='.$pet['idPet'].'">
								<img src="img/animals/'.$pet['type'].'.png">
								</a>
								'.$pet['name'].'
						</div></li>';
					}
				} else {
					echo $num;
					echo '<h2>'.$user->username().' doesn\'t own any pets!</h2>';
				}
				?>
			</ul>
			<button type="button" id="button-add-pet" onclick="window.location.href='addPet.php'"> + </button>
		</div>

		

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>
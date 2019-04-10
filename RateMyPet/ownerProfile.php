<?php
	require_once __DIR__.'/include/Usuario.php';
	require_once __DIR__.'/include/config.php';
	require_once __DIR__.'/include/selectUser.php';	// This loads the current viewed user ($user) and checks if it's me ($me)	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Rate My Pet - profile</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
	<link rel="stylesheet" href="css/profile.css">
</head>
<body>
	<?php
		require("include/comun/header.php");
	?>

	<div class="content">
		<div id="image">
		<?php
			/*if ($me) { // If this is me
				echo '<h1>This is your Profile Page</h1>
				<p>Here you will be able to select any of your pet accounts, add a new pet, change your profile settings...</p>';


			} else { // This is someone else's profile
				echo '<h1>This is '.$user->username().'\'s Page</h1>';
						
			}*/
		
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

			//cambiar foto de perfil
			echo '<tr>
				<td><form class="file" action="include/procesarFichero.php" method="POST" enctype="multipart/form-data">
			Change photo(jpg/png): 
			<input type="file" name="file" accept="image/*" id="upload" >
			<input type="submit" value="Change">
			</form></td>
			</tr>';
		
		?>
		</div>
		<div>
		<table id="info">
		
		<?php // Añadir queries para coger los parámetros Following, Followers, rank...

			
			echo '
			<tr>
				<td>'.$user->username().'</td>
			</tr>
			<tr>
				 <td>'.$user->email().'</td>
			</tr>
			<tr>
				<td><a href="followers.php?id='.$user->id().'&followersUsers">Followers</a></td> <td>'.$user->followerAmount().'</td>
			</tr>
			<tr>
				<td><a href="followers.php?id='.$user->id().'&followingUsers">Following</a></td> <td>'.$user->followingAmount().'</td>
			</tr>
			';

			if ($me){
			
				echo '<tr>
					<td><button type="button" id="button-follow" onclick="window.location.href=\'updateUser.php?id='.$user->id().'\'">Edit</button></td>
				</tr>';
			}
			else{
				if ($following) {
					echo '<tr>
					<td><button type="button" id="button-follow" onclick="window.location.href=\'include/follow.php?action=unfollowUser&id2='.$user->id().'\'"> Unfollow </button></td>
				</tr>';
				} else {
					echo '<tr>
					<td><button type="button" id="button-follow" onclick="window.location.href=\'include/follow.php?action=followUser&id2='.$user->id().'\'"> Follow </button></td>
				</tr>';
				}
			}
			
			
			
		?>
		</table>
		</div>
		<div id="rankingPerfil">
		<table>
			<tr>
				<td>Current Weekly Rank: </td> <td>#302</td>
			</tr>
			<tr>
				<td>Best Weekly Rank: </td> <td>#3</td>
			</tr>
		</table>
		</div>

		<div class="display-pets">
			<div>
			<?php
				if ($me) {
					echo '<h1>My pets</h1>';
				} else {
					echo '<h1>'.$user->username().'\'s Pets</h1>';
				}
			?>
			</div>
			<div>
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
					if ($me) {
						echo "<h2>You don't own any pets!</h2>";
					} else {
						echo '<h1>'.$user->username().' doesn\'t own any pets!</h1>';
					}
				}
				?>
			<?php
				if ($me) {
					echo '<button type="button" class="button-create" onclick="window.location.href=\'addPet.php\'">Add a pet</button>';
				}
			?>
			</ul>
			
			</div>
		</div>
	</div>

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>
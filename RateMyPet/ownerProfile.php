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
	<link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php
		require("include/comun/header.php");
	?>

	<div class="content">
		<div class="data">
			<div class="profile-image">
				<?php	
					$_SESSION["ownerOpet"]="owner";
					$path='upload/users/'.$_SESSION["username"];
					$image = "";
					if (file_exists('upload/users/'.$_SESSION["username"].'.jpg')) {
						$image = 'src='.$path.'.jpg';
					} else if (file_exists('upload/users/'.$_SESSION["username"].'.png')) {
						$image = 'src='.$path.'.png';
					} else {
						$image = 'src="upload/users/default.png"';
					}
					echo '<img '.$image. '>';
				?>
			</div>
			<div class="info">
				<?php
					echo '<h2>'.$user->username().' (aka: '.$user->fullName().')</h2>';
					echo '<h2>Followers: <a href="followers.php?followersUsers&id='.$user->id().'">'.$user->followerAmount().'</a> | ';
					echo 'Following: <a href="followers.php?followingUsers&id='.$user->id().'">'.$user->followingAmount().'</a></h2>';
					// Likes / Repets

					echo '<h2>Likes: <a href="myLikes.php?id='.$user->id().'">'.$user->likedAmount().'</a> | ';
					echo 'RePets: <a href="myRepets.php?id='.$user->id().'">'.$user->repetAmount().'</a></h2>';

					// Edit Button
					if ($me) {
						echo '<button type="button" class="button-create" onclick="window.location.href=\'updateUser.php?id='.$user->id().'\'">Edit Profile</button>';
					}
				?>
			</div>
		</div>
		<hr>
		<div class="pets">
			<?php // My pets
				if ($me) {
					echo '<h1>My pets</h1>';
				} else {
					echo '<h1>'.$user->username().'\'s Pets</h1>';
				}
			?>
			<div class="multiple-items">
				<?php
					if ($myPets->num_rows > 0) { // Iterate through all of my pets
						while($row = $myPets->fetch_assoc()) {
							$pet = Pet::buscarPet($row['idPet']);
							echo '<a href="petProfile.php?idPet='.$pet->petId().'">';
								echo '<div class="pet-view">
								<h1>'.$pet->petName().'</h1>
								<h2>'.$pet->getImage().'</h2>
								</div>';
							echo '</a>';
						}
					} else {
						echo '<div>';
						if ($me) {
							echo "<h2>You don't own any pets!</h2>";
						} else {
							echo '<h1>'.$user->username().' doesn\'t own any pets!</h1>';
						}
						echo '</div>';
					}
				?>  
			</div>
			<div class="add-pet">
				<?php
					if ($me) {
						echo '<button type="button" class="button-create" onclick="window.location.href=\'addPet.php\'">Add a pet</button>';
					}
				?>
			</div>
		</div>
	</div>
	<?php
		require("include/comun/footer.php");
	?>
<script src="js/changeImage.js"> </script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
            $('.multiple-items').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 3,
                autoplay: true,
                autoplaySpeed: 3000,
                dots: true,
                speed: 700,
                arrows: true
            });
        });
</script>
<script>

		function editIcon() {

		}

</script>
</body>
</html>
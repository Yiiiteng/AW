<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rate My Pet - perfil</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/perfil.css">
</head>
<body class="color-fondo">
	<?php
		require("include/comun/cabecera.php");
	?>

	<div class="card" id="owner">
		<div class="infoOwner">

			<div class="content-img">
				<img src="usuarios/laura.png" alt="Logo" width="100" height="100" />
	            <div class="file">
	                <i class="ico-plus"></i>Subir foto(jpg/png): <input type="file" name="file" accept="image/*" id="upload" >
	            </div>  
	        </div>

			<table id="info">
				<tr>
				<!--echo $_SESSION['nombre'];-->
					<th>Laura</th>
				</tr>
				<tr>
					<!--echo $_SESSION['id'];-->
					<th>@laura123</th>
				</tr>
				<tr>
					<!--echo $_SESSION['followed']; need add a function-->
				<th>48 seguidores</th>
				</tr>
			</table>

			<div id="rankingPerfil">
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
			</div>
		</div>

	</div>

	<div class="card" id="myPet">
		<h3>My pets</h3>
		<?php
		
		?>
		<button type="button" id="button-add-pet" onclick="window.location.href='addPet.php'"> + </button>
	</div>

</body>
</html>
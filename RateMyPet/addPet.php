﻿<?php
	require_once __DIR__.'/include/Aplicacion.php';
	require_once __DIR__.'/include/config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rate My Pet: Add your pet</title>
	<link rel="stylesheet" type="text/css" href="css/perfil.css">
</head>

<body class="color-fondo">
	
	<div class="contenedor-add">
	<form action="include/procesarRegistroPet.php" method="POST" enctype="multipart/form-data">
		<div class="contenedor-add">
			<div id="contenedor-perfil-img">
				<div class="contenedor-title">
					<h2>Add your pet</h2>
				</div>
				<img src="usuarios/default.png" alt="Logo" width="300" height="300" />
				<div class="content-img">
		            <div class="file">
		                Subir foto(jpg/png): 
		                <input type="file" name="file" accept="image/*" id="upload" >
		            </div>  
		        </div>
			</div>

			<div>
				<table>
					<tr>
						<td>Name: </td>
						<td><input class="form-control" id = "petName" type="text" name="petName" required>
						</td>
					</tr>
					<tr>
						<td>Type: </td>
						<td>
						<select id="petType" type="text" name="petType">
							<option value="Dog">Dog</option>
							<option value="Cat">Cat</option>
							<option value="Hamster">Hamster</option>
							<option value="Rabbit">Rabbit</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Breed: </td>
						<td><input class="form-control" id = "breed" type="text" name="petBreed" required>
						</td>
					</tr>
					<tr>
						<td>Description: </td>
						<td>
							<textarea class="form-control" rows="5" cols="40" id = "descript" name="petDescript">
							</textarea>
						</td>
					</tr>
				</table>
			</div>
			<button>Create!</button>
		</div>
		
	</form>
	</div>
</body>
</html>

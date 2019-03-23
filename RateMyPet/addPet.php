<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rate My Pet: Add your pet</title>
	<link rel="stylesheet" type="text/css" href="css/perfil.css">
</head>

<body class="color-fondo">
	
	<div class="contenedor-add">

		<div id="contenedor-perfil-img">
			<div class="contenedor-title">
				<h2>Add your pet</h2>
			</div>
			<img src="usuarios/default.png" alt="Logo" width="300" height="300" />
			<div class="content-img">
	            <div class="file">
	                <i class="ico-plus"></i>Subir foto(jpg/png): <input type="file" name="file" accept="image/*" id="upload" >
	            </div>  
	        </div>
		</div>

		<div>
			<form action="include/procesarRegistroPet.php" method="POST">
			<table>
				<tr>
					<td>Name: </td>
					<td><input class="form-control" id = "petName" type="text" name="pet">
					</td>
				</tr>
				<tr>
					<td>Nick: </td>
					<td><input class="form-control" id = "petNickName" type="text" name="petNick">
					</td>
				</tr>
				<tr>
					<td>Breed: </td>
					<td><input class="form-control" id = "breed" type="text" name="petBreed">
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

			<button class="button-create">Create!</button>

			</form>
		</div>

	</div>
	</body>
</html>

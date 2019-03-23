<?php
	session_start();
	require_once "includes/config.php";
    require_once "includes/pet.php";

	 
		$nickName = isset($_POST['usuario']) ? $_POST['usuario'] : null;
		$contrasenia = isset($_POST['password']) ? $_POST['password'] : null;
		$nombre = isset($_POST['nomReg']) ? $_POST['nomReg'] : null;
		$primerApellido = isset($_POST['ape1Reg']) ? $_POST['ape1Reg'] : null;
		$segundoApellido = isset($_POST['ape2Reg']) ? $_POST['ape2Reg'] : null;
		$fechaNac = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;
		$correo = isset($_POST['mail']) ? $_POST['mail'] : null;
		$telefono = isset($_POST['mobile']) ? $_POST['mobile'] : null;


		if(empty($nickName) or empty($contrasenia) or empty($nombre) or empty($primerApellido) or empty($fechaNac) or empty($correo))
			header("Location: ../errorRegistro.php");

		else{
			$usuario = Usuario::crea($nickName, null, $nombre, $primerApellido, $Segundo_Apellido, null,  $fechaNac, $correo, $telefono, 0, $contrasenia, 0);
			if (! $usuario ) {
		    	header("Location: ../errorRegistro.php");
			} else {
				$_SESSION["LogIn"] = TRUE;
				$_SESSION["username"] = $nickName;
				$_SESSION["idUser"] = $usuario->ID_Usuario();
				$_SESSION["nombre"] = $usuario->Nombre_Usuario();
				$_SESSION["primerApellido"] = $usuario->Primer_Apellido();
				$_SESSION["segundoApellido"] = $usuario->Segundo_Apellido();
				$_SESSION["imagenPerfil"] = $usuario->Imagen_Perfil();
				$_SESSION["fechaNacimiento"] = $usuario->Fecha_Nacimiento();
				$_SESSION["email"] = $usuario->Correo();
				$_SESSION["telefono"] = $usuario->Telefono();
				$_SESSION["testCompletado"] = $usuario->Test();
				if($usuario->Es_Admin() == '1')
    				$_SESSION['esAdmin'] = true;
				header('Location: ../index.php');
				exit();

			}
		 }
	

?>
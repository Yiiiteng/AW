<?php
require_once __DIR__ . '/include/Aplicacion.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/FormularioPet.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Rate My Pet: Add your pet</title>
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<?php
require("include/comun/header.php");
?>
<div>
	<?php
	$opciones = array(); // Ninguna por defecto
	$formulario = new FormularioPet("Pet", $opciones); // Créame una instancia hija de Form de tipo FormularioPet
	$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Añadir Pet
	?>
	<div>
		<?php
		require("include/comun/footer.php");
		?>
		<script >
			function getBreed() {
				var animal = document.getElementById("petType");
				var option = animal.options[animal.selectedIndex].value;
				let html = "";
				switch (option) {
					case "Dog":
						console.log("Dog");
						html = '<select class="form-"control" id="breed" type="text" name="breed"><option value="Labrador Retriever">Labrador Retriever</option><option value="Bulldog">Bulldog</option><option value="Caniche">Caniche</option><option value="Beagle">Beagle</option><option value="German Shepherd Dog">German Shepherd Dog</option><option value="Golden Retriever">Golden Retriever</option><option value="French Bulldog">French Bulldog</option><option value="Boxers">Boxers</option><option value="Yorkshire Terrier">Yorkshire Terrier</option><option value="Rottweilers">Rottweilers</option></select>';
						document.getElementById("breed").innerHTML = html;
						break;
					case "Cat":
						console.log("Cat");
						html = '<select class="form-"control" id="breed" type="text" name="breed"><option value="Abyssinian">Abyssinian</option><option value="Aegean">Aegean</option><option value="Bengal">Bengal</option><option value="Bombay">Bombay</option><option value="Burmese">Burmese</option><option value="Khao Manee">Khao Manee</option><option value="Lykoi">Lykoi</option><option value="Manx">Manx</option><option value="Pixie-bob">Pixie-bob</option></select>';
						document.getElementById("breed").innerHTML = html;
						break;
					case "Hamster":
						console.log("Hamster");
						html = '<select class="form-"control" id="breed" type="text" name="breed"><option value="Syrian">Syrian</option><option value="Robo">Robo</option><option value="Winter White">Winter White</option><option value="Chinese">Chinese</option><option value="Campbell">Campbell</option><option value="Winter White">Winter White</option></select>';
						document.getElementById("breed").innerHTML = html;
						break;
					case "Rabbit":
						console.log("Rabbit");
						html = '<select class="form-"control" id="breed" type="text" name="breed"><option value="Lionhead">Lionhead</option><option value="Flemish Giant">Flemish Giant</option><option value="Holland Lop">Holland Lop</option><option value="Continental Giant">Continental Giant</option><option value="Netherland Dwarf">Netherland Dwarf</option><option value="Dutch Rabbit">Dutch Rabbit Dwarf</option><option value="English Lop">English Lop</option><option value="French Lop">French Lop</option><option value="Mini Rex">Mini Rex</option></select>';
						document.getElementById("breed").innerHTML = html;
						break;
				}
				
			}
		</script>



		</body>

</html>
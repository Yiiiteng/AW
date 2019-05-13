function preview(event) 
{
if(e.files && e.files[0])
	{
 
		// Comprobamos que sea un formato de imagen
		if (e.files[0].type.match('image.png') || e.files[0].type.match('image.jpg')) {
 
			// Inicializamos un FileReader. permite que las aplicaciones web lean 
			// ficheros (o información en buffer) almacenados en el cliente de forma
			// asíncrona
			// Mas info en: https://developer.mozilla.org/es/docs/Web/API/FileReader
			var reader=new FileReader();
 
			// El evento onload se ejecuta cada vez que se ha leido el archivo
			// correctamente
			reader.onload=function(e) {
				//document.getElementById("preview").innerHTML="<img src='"+e.target.result+"'>";
				console.log(e.target.result);
			}
 
			// El evento onerror se ejecuta si ha encontrado un error de lectura
			reader.onerror=function(e) {
				document.getElementById("preview").innerHTML="Error de lectura";
			}
 
			// indicamos que lea la imagen seleccionado por el usuario de su disco duro
			reader.readAsDataURL(e.files[0]);
		}else{
 
			// El formato del archivo no es una imagen
			document.getElementById("preview").innerHTML="No es un formato de imagen";
		}
	}

}
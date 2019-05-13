
function changeImage() {
    var image = document.getElementById('myImage');

    //console.log(image.target);
    image.innerHTML="form class='file' action='include/procesarFichero.php' method='POST' enctype='multipart/form-data'> <input type='file' name='file' accept='image/*'' id='upload'> <input type='submit' value='Change'>;"
    //image.src = image.target.result;
}

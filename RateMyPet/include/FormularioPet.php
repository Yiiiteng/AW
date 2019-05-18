<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Pet.php';

class FormularioPet extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        return '<div class="edit">
                        <div class="edit-title">
                            <h1>Add a Pet</h1>
                        </div>
                        <div class="edit-photo">
                            <img name="image" id="output" src="upload/users/default.png">
                            <h3>Image Preview</h3>
                        </div>
                        <div clas="info">
                            <table>
                                <td>Profile Photo (jpg/png): </td>
                                <td>
                                    <input type="file" onchange="readURL(this);" name="image" enctype="multipart/form-data" required/>
                                </td>
                                <tr>
                                    <td>Name: </td>
                                    <td><input class="form-control" id = "petName" type="text" name="petName" placeholder="Name" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Type: </td>
                                    <td>
                                    <select onchange= "getBreed()" class="form-control" id="petType" type="text" name="petType">
                                        <option value="None">-</option>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                        <option value="Hamster">Hamster</option>
                                        <option value="Rabbit">Rabbit</option>
                                        <option value="Bird">Bird</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Breed: </td>
                                    <td>
                                    <select class="form-control" id="breed" type="text" name="petBreed">
                                        <option value="None">-</option>
                                    </select>
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
                    
                    <button class="button-create">Create!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.

        $petName = isset($_POST['petName']) ? $_POST['petName'] : null;
        $petType = isset($_POST['petType']) ? $_POST['petType'] : null;
        $petBreed = isset($_POST['petBreed']) ? $_POST['petBreed'] : null;
        $petDescript = isset($_POST['petDescript']) ? $_POST['petDescript'] : null;
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
        $owner_id = $_SESSION['user']->id();

        if (empty($petName) or empty($petType) or empty($petBreed))	{
            header('Location: ownerprofile.php');
            exit();
        } else{
            $treats = 0;
            $pet = Pet::insertar($petName,$petType,$petBreed,$petDescript,$treats,$owner_id);
            if ($image != null) {

                $name_file = $_FILES['image']['name']; // Nombre del archivo
                $tmp_name = $_FILES['image']['tmp_name'];  // Nombre y directorio temporal del archivo subido
                $extension = explode(".", $name_file)[1]; // Extensión del archivo
                
                // Procesa la imagen
                if (!$pet->processImage($tmp_name, $extension)) {
                    echo 'No se ha podido subir la imagen al servidor.';
                    exit();
                }
            }
            header('Location: ownerProfile.php?id='.$owner_id);
            exit();
        }
    }

}

?>
<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Pet.php';

class FormularioPost extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        return '<div class="contenedor-add">
                    <div>
                        <div class="contenedor-title">
                            <h2>Add a Post</h2>
                        </div>
                        <div>
                            <table>
                            <tr>
                                <td>Title: </td>
                                <td><input class="form-control" id = "title" type="text" name="title" placeholder="New Post" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Tags: </td>
                                <td><input class="form-control" id = "tags" type="text" name="tags" placeholder="#Dog" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Description: </td>
                                <td>
                                    <textarea class="form-control" rows="5" cols="40" id = "description" name="description">
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Image: </td>
                                <td>
                                <input type="file" accept="image/*" onchange="loadFile(event)">
                                <img id="output"/>
                                </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                    <button class="button-create">Post!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.

        $petName = isset($_POST['petName']) ? $_POST['petName'] : null;
        $petType = isset($_POST['petType']) ? $_POST['petType'] : null;
        $petBreed = isset($_POST['petBreed']) ? $_POST['petBreed'] : null;
        $petDescript = isset($_POST['petDescript']) ? $_POST['petDescript'] : null;
        $owner_id = isset($_SESSION['owner_id']) ? $_SESSION['owner_id'] : null;

        if (empty($petName) or empty($petType) or empty($petBreed))	{
            header('Location: ownerprofile.php');
            exit();
        } else{
            $dir='../usuarios/'.$_SESSION["username"].'/'.$petName;
            if (is_dir($dir)) {
                echo "This pet already exists!";
            }
            else{
                $dir='../usuarios/'.$_SESSION["username"];
                if (is_dir($dir)===false) {
                    mkdir($dir);
                }
                $petdir=$dir.'/'.$petName;
                mkdir($petdir);

                move_uploaded_file($_FILES["file"]["tmp_name"], $petdir.'/'.$_FILES["file"]["name"]);

                if($_FILES["file"]["type"]==="image/png"){
                    rename( $petdir.'/'.$_FILES["file"]["name"], $petdir.'/'.$petName.'.png');
                }
                else if($_FILES["file"]["type"]==="image/jpg"){
                    rename( $petdir.'/'.$_FILES["file"]["name"], $petdir.'/'.$petName.'.jpg');
                }
                else {
                    
                }
            }

            $treats = 0;
            $pet = Pet::insertar($petName,$petType,$petBreed,$petDescript,$treats,$owner_id);

            header('Location: ownerprofile.php');
            exit();
        }
    }

}

?>
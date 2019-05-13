<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Pet.php';

class FormularioPet extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        return '<div class="contenedor-add">
                    <div>
                        <div class="contenedor-title">
                            <h2>Add your pet</h2>
                        </div>
                        <div>
                            <table>
                            <tr>
                                <td>Name: </td>
                                <td><input class="form-control" id = "petName" type="text" name="petName" placeholder="Name" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Type: </td>
                                <td>
                                <select class="form-"control" id="petType" type="text" name="petType">
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Hamster">Hamster</option>
                                    <option value="Rabbit">Rabbit</option>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Breed: </td>
                                <td><input class="form-control" id = "breed" type="text" name="petBreed" placeholder="Breed" required>
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
                    </div>
                    <button class="button-create">Create!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.

        $petName = isset($datos['petName']) ? $datos['petName'] : null;
        $petType = isset($datos['petType']) ? $datos['petType'] : null;
        $petBreed = isset($datos['petBreed']) ? $datos['petBreed'] : null;
        $petDescript = isset($datos['petDescript']) ? $datos['petDescript'] : null;

        if (empty($petName) or empty($petType) or empty($petBreed))	{
            header('Location: ownerProfile.php?id='.$_SESSION['user']->id().'');
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
            $pet = Pet::insertar($petName,$petType,$petBreed,$petDescript,$treats,$_SESSION['user']->id());

            header('Location: ownerProfile.php?id='.$_SESSION['user']->id().'');
            exit();
        }
    }

}

?>
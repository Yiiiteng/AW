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

                /*<script>       ------ RETRIEVE VALUE WITHOUT SUBMIT
 var changeInput = function  (val){
            var input = document.getElementById("age");
            input.value = val;
        }
</script>*/
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

            header('Location: ownerProfile.php?id='.$owner_id);
            exit();
        }
    }

}

?>
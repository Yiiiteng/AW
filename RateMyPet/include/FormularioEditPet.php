<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Pet.php';

class FormularioEditPet extends Form {

    protected function generaCamposFormulario($datos) { // Devuelve el HTML necesario para presentar los campos del formulario.
        $id_pet = $_GET['id'];
        return '<div class="contenedor-add">
                    <div>
                        <div class="contenedor-title">
                            <h2>Edit your pet</h2>
                        </div>
                        <div>
                            <table>
                            <tr>
                                <td>Name: </td>
                                <td><input class="form-control" id = "petName" type="text" name="petName" placeholder="Name" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Description: </td>
                                <td>
                                    <textarea class="form-control" rows="5" cols="40" id = "descript" name="petDescript">
                                    </textarea>
                                </td>
                            </tr>
                            <input type="hidden" name="id_pet" value="'.$id_pet.'"/>
                            </table>
                        </div>
                    </div>
                    <button class="button-create">Edit!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.
        $erroresFormulario = array();

        $petName = isset($datos['petName']) ? $datos['petName'] : null;
        $petDescript = isset($datos['petDescript']) ? $datos['petDescript'] : null;
        $id_pet = $datos['id_pet'];

        if (empty($petName)){
            $erroresFormulario[] = "petName cannot be empty." ;
        }
        if (empty($petDescript)){
            $erroresFormulario[] = "Description cannot be empty.";
        } 

        if (count($erroresFormulario) === 0) {
            $pet = Pet::actualizar($datos);
            if(!$pet){
                $result[] = "No se ha podido actualizar";
            } else {
                header('Location: petProfile.php?idPet='.$id_pet);
            }
        }
    }

}

?>
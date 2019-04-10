<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Pet.php';

class FormularioEditPet extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
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
                            </table>
                        </div>
                    </div>
                    <button class="button-create">Create!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.
        $petName = isset($_POST['petName']) ? $_POST['petName'] : null;
        $petDescript = isset($_POST['petDescript']) ? $_POST['petDescript'] : null;

        if (empty($petName) or empty($petType))	{
            header('Location: petProfile.php');
            exit();
        } else{
            $pet = Pet::insertar($petName,$petType,$petBreed,$petDescript,$treats,$owner_id);

            header('Location: petProfile.php?id='.$owner_id);
            exit();
        }
    }

}

?>
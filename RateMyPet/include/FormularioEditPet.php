<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Pet.php';

class FormularioEditPet extends Form {

    
    protected function generaCamposFormulario($datos) { // Devuelve el HTML necesario para presentar los campos del formulario.
        $pet = Pet::buscarPet($_GET['id']);
        unset($_FILES['image']);
        return '<div class="edit">
                    <div class="edit-title">
                        <h1>Edit profile</h1>
                    </div>
                    <div class="edit-photo">
                        <img name="image" id="output" src="' . $pet->getImageSrc() . '">
                        <h3>Image Preview</h3>
                    </div>
                    <div class="info">
                        <table>
                        <tr>
                            <td>Profile Photo (jpg/png): </td>
                            <td>
                                <input type="file" onchange="readURL(this);" name="image" enctype="multipart/form-data" />
                            </td>
                        </tr>
                        <tr>
                            <td>Name: </td>
                            <td>
                                <input class="form-control" id = "petName" type="text" name="petName" placeholder="Name">
                            </td>
                        </tr>
                        <tr>
                            <td>Description: </td>
                            <td>
                                <textarea class="form-control" rows="5" cols="40" id = "descript" name="petDescript">
                                </textarea>
                            </td>
                        </tr>
                        <input type="hidden" name="id_pet" value="'.$pet->petId().'"/>
                        </table>
                    </div>
                </div>
                <div class="buttons">
                    <button class="button-create" id="update" >Update</button>
                    <button class="button-create" id="update" name="cancel" >Cancel</button>
                    <button class="button-create" id="update" name="delete" >Delete Pet?</button>
                </div>';
    }

    protected function procesaFormulario($datos) {
        $erroresFormulario = array();
        $petName = isset($datos['petName']) ? $datos['petName'] : null;
        $descript = isset($datos['descript']) ? $datos['descript'] : null;
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;

        if (isset($datos['cancel'])) {
            header('Location: petProfile.php?id='.$datos['id_pet'].'');
            exit();
        } else if (isset($datos['delete'])) {
            header('Location: deleteConfirm.php?pet='.$datos['id_pet'].'');
            exit();
        } else { // Update
            if ($petName == null && $descript == null && ($image == null || $image == "")) {
                $erroresFormulario = array();
                $erroresFormulario[] = 'You must at least change one of the fields, or click on "Cancel" otherwise.';
                $_GET['id'] = $datos['id_pet'];
                return $erroresFormulario;
            } else {
                $id = $datos['id_pet'];
                $pet = Pet::buscarPet($datos['id_pet']);
                if ($pet != null) {
                    $pet->actualiza($datos, $id);
                    if (!$pet) {
                        echo "No se ha podido actualizar los datos";
                    } else {
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
                        unset($_FILES['image']);
                        header("Location: petProfile.php?idPet=" .$datos['id_pet']);
                        exit();
                    }
                }
            }
        }
    }

}

?>
<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioEditUser extends Form {

     protected function generaCamposFormulario($datos) { // Devuelve el HTML necesario para presentar los campos del formulario.
        $id_user = $_GET['id'];
        $print = '';
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "repeat") {
                $print = '<p>Unchanged values.</p>';
            }
        }
        $user = Usuario::buscaUsuarioId($id_user);
        $print = $print.'<div class="contenedor-add">
                    <div>
                        <div class="contenedor-title">
                            <h2>Edit profile</h2>
                        </div>
                        <img class="cover-img" id="output" src="upload/users/'.$user->id().'.png" alt="Image not Found" onerror="this.src=\'upload/users/default.png\'">
                        <p class="centered">Image Preview</p>
                        <div>
                        <table>
                        <tr>
                        <td>Profile photo(jpg/png): </td>
                           <td>
                            <input type="file" id="image" name="image" class="cover-image" accept="*" onchange="loadFile(event)">
                            </td>
                        </tr>
                        <tr>
                            <td>Name: </td>
                            <td><input class="form-control" id = "username" type="text" name="username" 
                            placeholder="'.$user->username().'"/>
                            </td>
                        </tr>
                         <tr>
                            <td>Fullname: </td>
                            <td><input class="form-control" id = "FullName" type="text" name="FullName" 
                            placeholder="'.$user->fullname().'"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Email: </td>
                            <td><input class="form-control" id = "email" type="text" name="email" 
                            placeholder="'.$user->email().'"/>
                            </td>
                        </tr>
                        <input type="hidden" name="id_user" value="'.$id_user.'"/>
                        </table>
                        </div>
                    </div>
                    <button class="button-create">Update</button>
                </div>';
        return $print;
    }

    protected function procesaFormulario($datos) {
        $erroresFormulario = array();
        $userName = isset($datos['username']) ? $datos['username'] : null;
        $fullName = isset($datos['FullName']) ? $datos['FullName'] : null;
        $email = isset($datos['email']) ? $datos['email'] : null;

            $id = $_POST['id_user'];
            $user = Usuario::buscaUsuarioId($id);
            if ($user != null) {
                $user->actualiza($datos,$id);
                if (!$user) {
                    echo "No se ha podido actualizar los datos";
                } else {
                    header("Location: ownerProfile.php?id=".$datos['id_user']);
                }
            }
        return $erroresFormulario;
    }

        
}

?>

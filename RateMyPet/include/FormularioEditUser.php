<?php

require_once __DIR__ . '/Form.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Usuario.php';

class FormularioEditUser extends Form
{

    protected function generaCamposFormulario($datos) { // Devuelve el HTML necesario para presentar los campos del formulario.
        $id_user = $_GET['id'];
        $print = '';
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "repeat") {
                $print = '<p>Unchanged values.</p>';
            }
        }
        $user = Usuario::buscaUsuarioId($id_user);
        $print = $print . '<div class="edit">
                        <div class="edit-title">
                            <h1>Edit profile</h1>
                        </div>
                        <div class="edit-photo">
                            <img name="image" id="output" src="' . $user->getImageSrc() . '">
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
                                        <input class="form-control" id = "username" type="text" name="username" placeholder="' . $user->username() . '"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fullname: </td>
                                    <td>
                                        <input class="form-control" id = "FullName" type="text" name="fullName" placeholder="' . $user->fullname() . '"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email: </td>
                                    <td>
                                        <input class="form-control" id = "email" type="text" name="email" placeholder="' . $user->email() . '"/>
                                    </td>
                                </tr>
                        </table>
                        </div>
                    </div>
                    <input type="hidden" name="id_user" value="' . $id_user . '"/>
                    <div>
                        <button class="button-create" id="update" >Update</button>
                        <button class="button-create" id="update" name="cancel" >Cancel</button>
                        <button class="button-create" id="update" name="delete" >Delete Account?</button>
                    </div>';
        unset($_FILES['image']);
        return $print;
    }

    protected function procesaFormulario($datos) {
        $erroresFormulario = array();
        $userName = isset($datos['username']) ? $datos['username'] : null;
        $fullName = isset($datos['fullName']) ? $datos['fullName'] : null;
        $email = isset($datos['email']) ? $datos['email'] : null;
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;

        if (isset($datos['cancel'])) {
            header('Location: ownerProfile.php?id='.$_SESSION['user']->id().'');
            exit();
        } else if (isset($datos['delete'])) {
            header('Location: deleteConfirm.php?user');
            exit();
        } else { // Update
            if ($userName == null && $fullName == null && $email == null && ($image == null || $image == "")) {
                $erroresFormulario = array();
                $erroresFormulario[] = 'You must at least change one of the fields, or click on "Cancel" otherwise.';
                $_GET['id'] = $_SESSION['user']->id();
                return $erroresFormulario;
            } else {
                $id = $_POST['id_user'];
                $user = Usuario::buscaUsuarioId($id);
                if ($user != null) {
                    $user->actualiza($datos, $id);
                    if (!$user) {
                        echo "No se ha podido actualizar los datos";
                    } else {
                    
                        if ($image != null) {
                           
                            $name_file = $_FILES['image']['name']; // Nombre del archivo
                            $tmp_name = $_FILES['image']['tmp_name'];  // Nombre y directorio temporal del archivo subido
                            $extension = explode(".", $name_file)[1]; // Extensión del archivo

                            // Procesa la imagen
                            if (!$user->processImage($tmp_name, $extension)) {
                                echo 'No se ha podido subir la imagen al servidor.';
                                exit();
                            }
                        }
                        unset($_FILES['image']);
                        header("Location: ownerProfile.php?id=" . $datos['id_user']);
                        exit();
                    }
                }
            }
        }
    }
}

<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioUser extends Form {

     protected function generaCamposFormulario($datos) { // Devuelve el HTML necesario para presentar los campos del formulario.

        $id_user = $_GET['id'];
        return '<div class="contenedor-add">
                    <div>
                        <div class="contenedor-title">
                            <h2>Edit profile</h2>
                        </div>
                        <div>
                            <table>
                            <tr>
                                <td>Name: </td>
                                <td><input class="form-control" id = "username" type="text" name="username" 
                                placeholder="username"/>
                                </td>
                            </tr>
                             <tr>
                                <td>Fullname: </td>
                                <td><input class="form-control" id = "FullName" type="text" name="FullName" 
                                placeholder="FullName"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Email: </td>
                                <td><input class="form-control" id = "email" type="text" name="email" 
                                placeholder="Email"/>
                                </td>
                            </tr>
                             <input type="hidden" name="id_user" value="'.$id_user.'"/>
                            </table>
                        </div>
                    </div>
                    <button class="button-create">Update</button>
                </div>';
    }

    protected function procesaFormulario($datos) {
        $erroresFormulario = array();
    
        $username = isset($datos['username']) ? $datos['username'] : null;
        
        if (empty($username)) {
            $erroresFormulario[] = "Username cannot be empty."  ;
        }
        
        $FullName = isset($datos['FullName']) ? $datos['FullName'] : null;
        if ( empty($FullName) ) {
            $erroresFormulario[] = "Fullname cannot be empty.";
        }

         $Email = isset($datos['email']) ? $datos['email'] : null;
        if ( empty($Email) ) {
            $erroresFormulario[] = "Email cannot be empty." ;
        }
        $id = $datos['id_user'];
        if (count($erroresFormulario) === 0) {
            $user = Usuario::actualiza($datos);
            if(!$user){
                 $result[] = "No se ha podido actualizar";
            } else {
    
              header("Location:ownerProfile.php?id=".$id);
            }

        }
        return $erroresFormulario;
    }

        
}

?>

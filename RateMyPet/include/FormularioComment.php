<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Post.php';

class FormularioComment extends Form {

    protected function generaCamposFormulario($datosinicio) {
        $postId = $_POST['idPost'];
        return '<div class="grupo-control">
                    <label>Qué quieres decir:</label> 
                    <input class="form-control" type="text" name="content" placeholder="cosis"/>
                    <input type="hidden" name="idPost" value="'.$postId.'"/>
                </div>
                <div class="grupo-control">
                    <button type="submit" name="submit">Comment</button>
                </div>
                </fieldset>';
    }

    protected function procesaFormulario($datosproceso) {
        $erroresFormulario = array();
    
        $content = isset($_POST['content']) ? $_POST['content'] : null;
        $idPost = $datosproceso['idPost'];
        $idUser = $_SESSION['user']->id();

        if (empty($content)) {
            $erroresFormulario[] = "Say something, don't be shy!";
        }        
        if (count($erroresFormulario) === 0) {
            Post::addComment($idUser, $idPost, $content);
        }
        header('Location: postMascota.php?id='.$idPost.'');
        exit();
    }
        
}

?>

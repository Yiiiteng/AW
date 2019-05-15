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
                                <td><input class="form-control" id = "tags" type="text" name="tags" placeholder="#Dog">
                                </td>
                            </tr>
                            <tr>
                                <td>Description: </td>
                                <td>
                                    <textarea class="form-control" rows="5" cols="40" id = "description" name="description">
                                    </textarea>
                                </td>
                            </tr>
                        </div>
                        <div>
                            <table>
                            <tr>
                                <td>Image: </td>
                                <td>
                                <input type="file" name="file" accept="image/*" onchange="loadFile(event)">
                                <img id="output"/>
                                </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="idPet" value="'.$_POST["idPet"].'">
                    <button class="button-create">Post!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario nuevo PetPost

        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $tags = isset($_POST['tags']) ? $_POST['tags'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        $image = "";

        // Pet Variables

        $idPet = isset($_POST['idPet']) ? $_POST['idPet'] : null;

        if (empty($idPet)) { // You can't createa post without the ID
            header('Location: error.php');
            exit();
        }

        $pet = Pet::buscarPet($idPet);

        if (empty($title))	{
            header('Location: petProfile.php?idPet='.$idPet.'');
            exit();
        }

        // We also need to check whether or not the image exists (you can't post anything without an Image)

        $pet->addPost($title, $tags, $description, $image); // Create the Post

        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/posts/".$_FILES["file"]["name"]);
            if($_FILES["file"]["type"]=="image/png"){
                rename('upload/posts/'.$_FILES["file"]["name"], 'upload/posts/'.$title.'.png');
            } else if($_FILES["file"]["type"]=="image/jpeg"){
                rename('upload/posts/'.$_FILES["file"]["name"], 'upload/posts/'.$title.'.jpg');
            } else if($_FILES["file"]["type"]=="image/jpg"){
                rename('upload/posts/'.$_FILES["file"]["name"], 'upload/posts/'.$title.'.jpg');
            } else echo "Image form error.";
        header('Location: petProfile.php?idPet='.$idPet.'');
        exit();
    }

}

?>
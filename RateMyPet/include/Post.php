<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Pet.php';
require_once __DIR__ . '/Usuario.php';

class Post {

    // Variables

    private $idpost; // Auto-set
    private $petid; // Auto-set
    private $userid; // Auto-set
    private $description; // User specified
    private $likes; // Auto-set
    private $repets; // Auto-set
    private $time; // Auto-set
    private $image; // Auto-set

    public function __construct($petid, $title, $description, $likes, $repets, $time, $image) {
        $this->petid = $petid;
        $this->title = $title;
        $this->$description = $description;
        $this->likes = $likes;
        $this->repets = $repets;
        $this->time = $time;
        $this->image = $image;
    }

    public static function buscaPost($idpost) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM posts U WHERE U.idpost = '%s'", $conn->real_escape_string($idpost));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc(); // Add following parameters
                $post = new Post($fila['idpost'], $fila['petid'], $fila['userid'], $fila['content'], $fila['likes'], $fila['repets'], $fila['tiempo'], $fila['petname']);
                $result = $post;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function allPosts($idPet) { // Given an Owner ID, returns a list with all the pets
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = "SELECT * FROM posts  WHERE petid =$idPet";
        $rs = $connect->query($sql);
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function submitPost() {
        // idpost / time / likes / repets / petid / description
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = "INSERT INTO posts VALUES ('', '.$this->time.', '.$this->likes.', '.$this->repets.', '.$this->petid.', '.$this->description.')";
        $rs = $conn->query($sql);
        $idPost = $conn->insert_id;
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
    

    public function idpost() {
        return $this->idpost;
    }

    public function petid() {
        return $this->petid;
    }

    public function userid() {
        return $this->userid;
    }

    public function likes() {
        return $this->likes;
    }

    public function repets() {
        return $this->repets;
    }

    public function tiempo() {
        return $this->tiempo;
    }
    public function contenido() {
        return $this->content;
    }


        public function toString($post) { // te printea un post a poartir de una row
        $pet = $post['petname'];
        $idpet = $post['petid'];
        $tiempo = $post['tiempo'];
        $likes = $post['likes'];
        $content = $post['content'];
        $repets = $post['repets'];
        return '<h1><a href="petProfile.php?idPet='.$idpet.'">'.$pet.'</a></h1>
                <h2>'.$content.'</h2>
                <h3>'.$repets.' Repets '.$likes.' Likes</h3>
                <h3>Date: '.$tiempo.'</h3>
                </br>';
    }
}

<?php
require_once __DIR__ . '/Post.php';
require_once __DIR__ . '/Usuario.php';

class Comment {

    // Variables

    private $idpost; // Auto-set
    private $idcomment; // Auto-set
    private $iduser; // Auto-set
    private $content; // User specified
    private $likes; // Auto-set
    
    public function __construct($idpost, $idcomment, $iduser, $content, $likes) {
        $this->idpost = $idpost;
        $this->idcomment = $idcomment;
        $this->iduser = $iduser;
        $this->content = $content;
        $this->likes = $likes;
       
    }

    public static function allComments($idpost) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM comments C WHERE C.idpost = '%s'", $conn->real_escape_string($idpost));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function parseComment($idpost, $iduser, $idcomment) { // Given an Owner ID, returns a list with all the pets
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = "SELECT * FROM comments  WHERE idcomment = $idcomment AND idPost = $idpost AND idUser";
        $rs = $connect->query($sql);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            return $comment = new Comment($fila['idPost'], $fila['idcomment'], $fila['idUser'], $fila['content'], $fila['likes']);
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

     public function idpost() {
        return $this->idpost;
    }

    public function iduser() {
        return $this->iduser;
    }

    public function content() {
        return $this->content;
    }

    public function idcomment() {
        return $this->idcomment;
    }

    public function likes() { // Loads the amount of likes
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM likedComments WHERE idComment = '.$this->idcomment.'';
        $rs = $connect->query($sql);
        if ($rs) {
            return ($rs->num_rows);
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function toString() { //
        $content = $this->content();
        $likes = $this->likes();
        $name = Usuario::buscaUsuarioId($this->iduser)->fullname();//coger el nombre del pet de algun stitio
        $string = '<h2>'.$name.'</h2>
        <h2>'.$content.'</h2>';
        if ($likes > 0) {
            $string = $string.''.$likes.' <a href="viewLikes.php?id='.$this->idpost().'">Likes</a></h3>';
        } else {
            $string = $string.''.$likes.' Likes';
        }
        return $string;
    }
}


?>
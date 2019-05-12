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

    public function submitPost() {
        // idpost / time / likes / repets / petid / description
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        // INSERT INTO `posts` (`idpost`, `time`, `likes`, `repets`, `petid`, `description`) VALUES (NULL, '2019-04-12', '9', '7', '29', NULL);
        $sql = 'INSERT INTO posts VALUES (NULL, \''.$this->title.'\',\''.$this->time.'\', '.$this->likes.', '.$this->repets.', '.$this->petid.', \''.$this->description.'\', 1)';
        echo ''.$sql;
        $rs = $conn->query($sql);
        $idPost = $conn->insert_id;
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public function borrarPost($postid){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = "DELETE FROM posts where idpost = '$postid'";
        $result = $conn->query($sql);
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

    public function isPending() {
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM posts WHERE idpost = '.$this->idpost.'';
        $rs = $connect->query($sql);
        if ($post = $rs->fetch_assoc()) {
            return ($post['pending'] == '1');
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function displayHome($postList, $numPosts) {
        $counter = 0;
        while($counter < $numPosts && $postList->num_rows > $counter) {
            $post = $postList->fetch_assoc();
            echo Post::toString($post);
            $counter = $counter + 1;
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

    // Mod Functions

    public static function getPending() {
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = "SELECT * FROM posts  WHERE pending = 1";
        $rs = $connect->query($sql);
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public static function checkSigned($mod, $post) { // Checks if a moderator has already signed the petition to verify a post
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM postvalidation WHERE idPost = '.$post.' AND idMod = '.$mod.'';
        $rs = $connect->query($sql);
        if ($rs->num_rows != 1) {
            return false;
        } else {
            return true;
        }
    }

    public function sign() {
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql= 'INSERT INTO postvalidation VALUES ('.$this->idpost().', '.$_SESSION['user']->id().')';
        $rs = $connect->query($sql);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

}


?>
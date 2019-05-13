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
    private $title; // Auto-set

    public function __construct($idpost, $petid, $title, $description, $likes, $repets, $time, $image) {
        $this->idpost = $idpost;
        $this->petid = $petid;
        $this->title = $title;
        $this->description = $description;
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
                $post = new Post($fila['idpost'], $fila['petid'], $fila['title'], $fila['description'], $fila['likes'], $fila['repets'], $fila['time'], '');
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

    public function addComment($idUser, $idPost, $content) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        // INSERT INTO `posts` (`idpost`, `time`, `likes`, `repets`, `petid`, `description`) VALUES (NULL, '2019-04-12', '9', '7', '29', NULL);
        $sql = 'INSERT INTO comments VALUES (NULL, \''.$idPost.'\',\''.$idUser.'\', \''.$content.'\', 0)';
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
    
    

    public function idpost() {
        return $this->idpost;
    }

    public function petid() {
        return $this->petid;
    }

    public function userid() {
        return $this->userid;
    }

    public function likes() { // Loads the amount of likes
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM likedposts WHERE idPost = '.$this->idpost.'';
        $rs = $connect->query($sql);
        if ($rs) {
            return ($rs->num_rows);
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function repets() { // Loads the amount of repets
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM repets WHERE idPost = '.$this->idpost.'';
        $rs = $connect->query($sql);
        if ($rs) {
            return ($rs->num_rows);
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function time() {
        return $this->time;
    }

    public function description() {
        return $this->description;
    }

    public function title() {
        return $this->title;
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
        $title = $this->title();
        $idpet = $this->petid();
        $time = $this->time();
        $likes = $this->likes();
        $description = $this->description();
        $repets = $this->repets();
        $name = Pet::buscarPet($idpet)->petName();//coger el nombre del pet de algun stitio
        $string = '<img id="post" src="upload/posts/'.$this->idpost().'.jpg">
        <h1>Post from: <a href="petProfile.php?idPet='.$idpet.'">'.$name.'</a></h1> 
        <h2>'.$title.'</h2>
        <h2>'.$description.'</h2>';
        if ($repets > 0) {
            $string = $string.'<h3>'.$repets.' <a href="viewRepets.php?id='.$this->idpost().'">Repets</a> | ';
        } else {
            $string = $string.'<h3>'.$repets.' Repets | ';
        }
        if ($likes > 0) {
            $string = $string.''.$likes.' <a href="viewLikes.php?id='.$this->idpost().'">Likes</a></h3>';
        } else {
            $string = $string.''.$likes.' Likes</h3>';
        }
        $string = $string.'<h3>Date: '.$time.'</h3>';
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

<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Post.php';

class Pet {
    private $petName;
    private $petId;
    private $petType;
    private $petBreed;
    private $petDescript;
    private $treats;
    private $owner_id;
    private $followers;

    public function __construct($petName, $petId, $petType, $petBreed, $petDescript, $treats, $owner_id) {
        $this->petName = $petName;
        $this->petId = $petId;
        $this->petType = $petType;
        $this->petBreed = $petBreed;
        $this->petDescript = $petDescript;
        $this->treats = $treats;
        $this->owner_id = $owner_id;
    }

    public static function existePet($idOwner, $petName) {
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = sprintf(
            "SELECT petName FROM pets WHERE idOwner = '%s' AND petName = '%s' ",
            $idOwner,
            $connect->real_escape_string($petName)
        );
        $consulta = mysqli_query($connect, $sql);

        if ($consulta && $consulta->num_rows == 1) {
            $consulta->free();
            return true;
        } else {
            return false;
        }
    }

    public static function buscarPet($idPet) {
        $control = Aplicacion::getSingleton();
        $conn = $control->conexionBd();
        $sql = "SELECT * FROM pets WHERE idPet = $idPet";
        $rs = $conn->query($sql);
        $result = false;
        if ($rs) {
            if ($rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $pet = new Pet($fila['name'], $fila["idPet"], $fila["type"], $fila["breed"], $fila["description"], $fila["treats"], $fila['owner_id']);
                $result = $pet;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function buscarNombreDueño($idOwner) {
        $control = Aplicacion::getSingleton();
        $conn = $control->conexionBd();
        $sql = "SELECT * FROM users WHERE id = $idOwner";
        $rs = $conn->query($sql);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $result = $fila['username'];
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    /* public static function crea($petName, $petId, $petType, $petBreed, $petDescript, $treats)
    {
        $pet = self::buscarPet($petName);
        if ($pet) {
            return false;
        }
        $pet = new Pet($petName,$petId,$petType,$petBreed,$petDescript,$treats);
        return self::guarda($pet);
    }*/

    public static function insertar($petName, $petType, $petBreed, $petDescript, $treats, $owner_id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf(
            "INSERT INTO pets(name,description,type,breed,treats,owner_id) VALUES('%s', '%s','%s','%s','%s', '%s')",
            $conn->real_escape_string($petName),
            $conn->real_escape_string($petDescript),
            $conn->real_escape_string($petType),
            $conn->real_escape_string($petBreed),
            $conn->real_escape_string($treats),
            $conn->real_escape_string($owner_id)
        );

        if ($conn->query($query)) {
            $petId = $conn->insert_id;
            return true;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function eliminar($idOwner, $petName) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf(
            "DELETE FROM pets where idOwner = '%s' AND petName = '%s'",
            $idOwner,
            $conn->real_escape_string($petName)
        );

        if ($conn->query($query)) {
            return true;
        } else {
            echo "Error al eliminar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function actualizar($pet){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $sql=sprintf("UPDATE pets SET name = '%s', description='%s' WHERE idPet=%s"
            , $conn->real_escape_string($pet['petName'])
            , $conn->real_escape_string($pet['petDescript'])
            , $conn->real_escape_string($pet['id_pet']));

        $consulta = mysqli_query($conn,$sql);

        if($consulta)
            return true;
        else{
            echo "Error al actualizar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
        return false;
        }
    
    }

    public static function allPets($idOwner) { // Given an Owner ID, returns a list with all the pets
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = "SELECT * FROM pets  WHERE owner_id =$idOwner";
        $rs = $connect->query($sql);
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function addPost($title, $tags, $description, $image) {
        $post = new Post($this->petId, $title, $description, 0, 0, time(), $image);
        $post->submitPost();
    }


    public function petName() {
        return $this->petName;
    }

    public function petId() {
        return $this->petId;
    }

    public function petType() {
        return $this->petType;
    }

    public function petBreed() {
        return $this->petBreed;
    }

    public function petDescription() {
        return $this->petDescript;
    }

    public function treats() {
        return $this->treats;
    }

    public function owner_id() {
        return $this->owner_id;
    }

    public function followerAmount() {
        // Update amount
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sqlFollowing = 'SELECT * FROM followedPets WHERE petId ='.$this->petId; // Return the user ID
        $result = $conn->query($sqlFollowing);
        $followers = $result->num_rows;
        return $followers;
    }

    public function toString($pet) {
        $name = $pet['name'];
        $type = $pet['type'];
        $breed = $pet['breed'];
        $id = $pet['idPet'];
        $owner_id = $pet['owner_id'];
        $owner = Pet::buscarNombreDueño($owner_id);
        return '<h1><a href="petProfile.php?idPet='.$id.'">'.$name.'</a></h1>
                <h3>Owned by: <a href="ownerProfile.php?id='.$owner_id.'">'.$owner.'</a></h3>
                <h2>'.$type.'</h2>
                <h3>'.$breed.'</h3>
                </br>';
    }
}
 
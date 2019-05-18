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
    private $topTreats;

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
                $pet->updateTopTreats($fila['topTreats']);
                $result = $pet;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public function updateTopTreats($treats) {
        $this->topTreats = $treats;
    }

    public static function buscarNombreDueño($idOwner) {
        $control = Aplicacion::getSingleton();
        $conn = $control->conexionBd();
        $sql = 'SELECT * FROM users WHERE id = '.$idOwner.'';
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
            return Pet::buscarPet($petId);
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public function borrarMascota() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM pets WHERE owner_id = '.$this->owner_id().' AND idPet = '.$this->petId.'';
        echo $sql;
        if ($conn->query($sql)) {
            return true;
        } else {
            echo "Error al eliminar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public function actualiza($datos,$id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $pet = self::buscarPet($id);


        // Check that what you're changing is different from what you have
        $petName = isset($datos['petName']) ? $datos['petName'] : null;
        $descript = isset($datos['descript']) ? $datos['descript'] : null;

        if ($petName != "") { // Change username
            $this->petName = $petName;
        }

        if ($descript != "") {
            $this->petDescript = $descript;
        }

        $sql = 'UPDATE pets SET name = \''.$this->petName.'\', description = \''.$this->petDescript.'\' WHERE idPet = '.$this->petId.'';
        
        if ($conn->query($sql) ) {
            return true;
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
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
        $post = new Post(NULL, $this->petId, $title, $description, 0, 0, date("Y/m/d"), $image);
        $post->submitPost();
    }

    public function addTreat() {
        // Update amount
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'UPDATE pets SET treats = '.($this->getTreats() + 1).' WHERE idPet = '.$this->petId().'';; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return true;
        }
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

    public function topTreats() {
        return $this->topTreats;
    }

    public function getImageSrc() {
        // This function gets the User's image, depending on the extension, and returns a default if it doesn't exist
        $src = 'upload/pets/'; // Image directory
        if (file_exists('upload/pets/'.$this->petId().'.jpg')) { 
            $src .= $this->petId().'.jpg';
        } else if (file_exists('upload/pets/'.$this->petId().'.png')) {
            $src .= $this->petId().'.png';
        } else if (file_exists('upload/pets/'.$this->petId().'.jpeg')) {
            $src .= $this->petId().'.jpeg';
        } else { // Default Image
            $src .= 'default/'.$this->petType().'.png';
        }
        return $src;
    }

    public function getTreats() {
        // Update amount
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT treats FROM pets WHERE idPet = '.$this->petId.''; // Return the user ID
        $result = $conn->query($sql);
        return $result->fetch_assoc()['treats'];
    }

    public function isVerified() {
        // Update amount
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM pets WHERE idPet = '.$this->petId.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            return ($result->fetch_assoc()['verified'] == 1);
        }
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

    // Edit Pet

    // Edit User

    public function processImage($tmp_name, $extension) {
        $result = false;
        $path = 'upload/pets/'; // Where the file is going to be saved
        // First, delete any image that existed previously with the same name
        unlink('upload/pets/'.$this->petId().'.jpg');
        unlink('upload/pets/'.$this->petId().'.png');
        unlink('upload/pets/'.$this->petId().'.jpeg');
        if (move_uploaded_file($tmp_name, $path.$this->petId().'.'.$extension)) {
            $result = true;
        } else {
            echo 'Something went wrong...';
            echo ''.$path;
            echo ''.$path.$this->petId().'.'.$extension;
            exit();
        }
        return $result;
    }

    // Timed Events

    public function maxRank() { // Max Rank of this pet (order)
        // Update amount
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM pets ORDER BY topTreats DESC'; // Return ALL the pets and order by 
        $result = $conn->query($sql);
        if ($result) {
            $i = 1; // First Position
            while ($row = $result->fetch_assoc()) {
                if ($this->petId() == $row['idPet']) { // Get only MY position
                    return $i;
                }
                $i++;
            }
        }
        else return null;
    }

    // Ranking 

    public static function getRanking() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT P.idPet, P.treats, P.owner_id FROM pets P ORDER BY P.treats DESC LIMIT 10 '; // Return current ranking
        $rs = $conn->query($sql);
        if($rs) {
            return $rs;
        }
    }

    public static function getTop() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT P.idPet, P.treats, P.owner_id FROM pets P ORDER BY P.topTreats DESC LIMIT 3 '; // Return current ranking
        $rs = $conn->query($sql);
        if($rs) {
            return $rs;
        }
    }

    // Verification

    public static function getNotVerified() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM pets WHERE verified = 0'; // Return current ranking
        $rs = $conn->query($sql);
        if($rs->num_rows > 0) {
            return $rs;
        } else return false;
    }

    public static function sayYes($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM petvalidation WHERE petId = '.$id.''; // Return current ranking
        $rs = $conn->query($sql);
        if($pet_ = $rs->fetch_assoc()) {
            if ($pet_['userIdA'] != NULL) {
                $sql = 'UPDATE petvalidation SET userIdA = '.$_SESSION['user']->id().''; // Accept
            } else if ($pet_['userIdB'] != NULL) {
                $sql = 'UPDATE petvalidation SET userIdB = '.$_SESSION['user']->id().''; // Accept
            } else if ($pet_['userIdC'] != NULL) { // This is the last Validation necessary
                $sql = 'UPDATE petvalidation SET userIdC = '.$_SESSION['user']->id().''; // Accept
                // UPDATE THE TABLE AND ACCEPT THE ACCOUNT
            }
        } else return false;
    }

    public static function sayNo($id) {

    }

}
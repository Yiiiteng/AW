<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Pet.php';

class Usuario {

    // Variables

    private $id; // Auto-set
    private $username; // User specified
    private $password; // User specified
    private $fullname; // User specified
    private $email; // User specified
    private $rol; // Admin specified

    // Followers & Following

    private $following; // Number of people I follow
    private $followers; // Number of people who follow me

    private function __construct($username, $fullname, $password, $email, $rol, $followers, $following) {
        $this->username= $username;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->email = $email;
        $this->rol = $rol;
        $this->followers = $followers;
        $this->following = $following;
    }

    public static function login($username, $password) {
        $user = self::buscaUsuario($username);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($username) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM users U WHERE U.username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc(); // Add following parameters
                $user = new Usuario($fila['username'], $fila['fullname'], $fila['password'], $fila['email'], $fila['rol'], $fila['numFollowers'], $fila['numFollowing']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function buscaUsuarioId($id) { // Returns user given an ID
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM users U WHERE U.id = '%s'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc(); // Add following parameters
                $user = new Usuario($fila['username'], $fila['fullname'], $fila['password'], $fila['email'], $fila['rol'], $fila['numFollowers'], $fila['numFollowing']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public function followsPet($petId) { // Returns user given an ID
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = "SELECT * FROM followedpets U WHERE U.userId = ".$this->id." AND U.petId = ".$petId."";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $result = true;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($username, $fullname, $password, $email, $rol) {
        $user = self::buscaUsuario($username);
        if ($user) {
            return false;
        }
        $user = new Usuario($username, $fullname, self::hashPassword($password), $email, $rol, 0, 0);
        return self::guarda($user);
    }

    public static function buscaMascotas($user) { // Return all my pets
        return Pet::allPets($user->id()); // Look for my pets (with my id)
    }
    
    private static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function guarda($usuario) {
        if ($usuario->id !== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }
    
    private static function inserta($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO users(username, fullname, password, email, rol) VALUES('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->fullname)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->rol));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
    
    public function actualiza($datos) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        // Check that what you're changing is different from what you have

        $name = isset($datos['username']) ? $datos['username'] : null;
        $fullName = isset($datos['FullName']) ? $datos['FullName'] : null;
        $email = isset($datos['email']) ? $datos['email'] : null;

        if ($name != "" && $name != $this->username) { // Change username
            $this->username = $name;
        }

        if ($fullName != "" && $fullName != $this->fullname) {
            $this->fullname = $fullName;
        }

        if ($email != "" && $name != $this->email) {
            $this->email = $email;
        }

        $sql = 'UPDATE users U SET username = \''.$this->username.'\', fullname = \''.$this->fullname.'\', email = \''.$this->email.'\' WHERE U.id = '.$this->id.'';
        
        if ($conn->query($sql) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $this->username;
                header("Location: updateUser.php?id=".$datos['id_user'].'&error=repeat');
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
       
    }

    public function id() {
        return $this->id;
    }

    public function rol() {
        return $this->rol;
    }

    public function username() {
        return $this->username;
    }

    public function email() {
        return $this->email;
    }

    public function followerAmount() {
        // Update amount
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sqlFollowing = 'SELECT * FROM seguimientos WHERE seguidorId ='.$this->id; // Return the user ID
        $result = $conn->query($sqlFollowing);
        $followers = $result->num_rows;
        return $followers;
    }

    public function followingAmount() {
        // Update amount
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sqlFollowing = 'SELECT * FROM seguimientos WHERE userId ='.$this->id; // Return the user ID
        $result = $conn->query($sqlFollowing);
        $following = $result->num_rows;
        return $following;
    }

    public function compruebaPassword($password) {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword) {
        $this->password = self::hashPassword($nuevoPassword);
    }

    public function toString($usuario) { // HTML Builder User
        $nick = $usuario['username'];
        $name = $usuario['fullname'];
        $email = $usuario['email'];
        $id = $usuario['id'];
        return '<h1><a href="ownerProfile.php?id='.$id.'">'.$nick.'</a></h1>
                <h2>'.$name.'</h2>
                <h3>'.$email.'</h3>
                </br>';
    }

    // Post functions

    public function checkLiked($postId) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM likedposts WHERE idUser = '.$this->id.' AND idPost = '.$postId.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            return true;
        } else return false;
    }

    public function checkRepeted($postId) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM repets WHERE idUser = '.$this->id.' AND idPost = '.$postId.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            return true;
        } else return false;
    }

    public function likedPosts() { // Return a list with the liked posts
        
    }

    public function likePost($postId) { // Like a post (add it to your liked list)
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'INSERT INTO likedposts VALUES ('.$this->id.', '.$postId.')'; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else return false;
    }

    public function unlikePost($postId) { // Unlike a post (remove it from your liked list)
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM likedposts WHERE idUser = '.$this->id.' AND idPost = '.$postId.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else return false;
    }

    public function repetedPosts() { // Return a list with the repeted posts
        
    }

    public function repetPost($postId) { // Repet a post (add it to your repeted list)
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'INSERT INTO repets VALUES ('.$this->id.', '.$postId.')'; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else return false;
    }

    public function unrepetPost($postId) { // Unrepet a post (remove it from your repeted list)
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM repets WHERE idUser = '.$this->id.' AND idPost = '.$postId.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else return false;
    }

    // Administrator Settings

    public static function getMods() { // Retrieves a list of current moderators for Rate My Pet
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM users WHERE moderator = 1'; // Return the user ID
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else return false;
    }

    public static function revokeMod($id) { // Revokes moderator priviledges from a user
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'UPDATE users U SET moderator = 0 WHERE id = '.$id.'';
        $result = $conn->query($sql);
        return $result;
    }

    public static function giveMod($id) { // Grants moderator priviledges for a user
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'UPDATE users SET moderator = 1 WHERE id = '.$id.'';
        $result = $conn->query($sql);
        return $result;
    }

    public function isMod() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM users WHERE id = '.$this->id.'';
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            if ($row['moderator'] == 1) return true;
            else return false;
        } else return false; 
    }

}

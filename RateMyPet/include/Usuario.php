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
        return self::inserta($user);
    }

    public static function buscaMascotas($user) { // Return all my pets
        return Pet::allPets($user->id()); // Look for my pets (with my id)
    }
    
    private static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function password() {
        return $this->password;
    }
    
    private static function inserta($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'INSERT INTO users VALUES (NULL, \''.$usuario->username().'\', \''.$usuario->fullname().'\', \''.$usuario->password().'\', \''.$usuario->email().'\', \'user\', 
        0, 0, 0, 3)'; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            $usuario->id = $conn->insert_id;
        }
        return $usuario;
    }

    // Edit User

    public function processImage($tmp_name, $extension) {
        $result = false;
        $path = 'upload/users/'; // Where the file is going to be saved
        // First, delete any image that existed previously with the same name
        unlink('upload/users/'.$this->id().'.jpg');
        unlink('upload/users/'.$this->id().'.png');
        unlink('upload/users/'.$this->id().'.jpeg');
        if (move_uploaded_file($tmp_name, $path.$this->id.'.'.$extension)) {
            $result = true;
        } else {
            echo 'Something went wrong...';
            echo ''.$path;
            echo ''.$path.$this->id.'.'.$extension;
            exit();
        }
        return $result;
    }
    
    public function actualiza($datos,$id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $user =self::buscaUsuarioId($id);


        // Check that what you're changing is different from what you have

        $name = isset($datos['username']) ? $datos['username'] : $user->username();
        $fullName =isset($datos['FullName']) ? $datos['FullName'] : $user->fullname();
        $email = isset($datos['email']) ? $datos['email'] : $user->email();


        if ($name != "") { // Change username
            $this->username = $name;
        }

        if ($fullName != "") {
            $this->fullname = $fullName;
        }

        if ($email != "" ) {
            $this->email = $email;
        }

        $sql = 'UPDATE users U SET username = \''.$this->username.'\', fullname = \''.$this->fullname.'\', email = \''.$this->email.'\' WHERE U.id = '.$this->id.'';
        
        if ($conn->query($sql) ) {
            return true;
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
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

    public function fullname() {
        return $this->fullname;
    }

    public function email() {
        return $this->email;
    }

    public function getImageSrc() {
        // This function gets the User's image, depending on the extension, and returns a default if it doesn't exist
        $src = 'upload/users/'; // Image directory
        if (file_exists('upload/users/'.$_SESSION['user']->id().'.jpg')) { 
            $src .= $_SESSION['user']->id().'.jpg';
        } else if (file_exists('upload/users/'.$_SESSION['user']->id().'.png')) {
            $src .= $_SESSION['user']->id().'.png';
        } else if (file_exists('upload/users/'.$_SESSION['user']->id().'.jpeg')) {
            $src .= $_SESSION['user']->id().'.jpeg';
        } else { // Default Image
            $src .= 'default.png';
        }
        return $src;
    }

    public function numTreats() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT treats FROM users WHERE id = '.$this->id; // Return the user ID
        $result = $conn->query($sql);
        return $result->fetch_assoc()['treats'];
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

    public function isFollowing($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM seguimientos WHERE (userId = '.$this->id.' AND seguidorId = '.$id.') OR
        (userId = '.$id.' AND seguidorId = '.$this->id.')'; // Return the user ID
        $result = $conn->query($sql);
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

    // Give Treat

    public function giveTreat($petId) { // Give a treat to a pet with id: petId (if you have treats available)
        if ($this->numTreats() > 0) {
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $sql = 'UPDATE users SET treats = '.($this->numTreats() - 1).' WHERE id = '.$this->id().'';; // Return the user ID
            $result = $conn->query($sql);
            if ($result) {
                $pet = Pet::buscarPet($petId);
                return $pet->addTreat();
            } else return false;
        } else {
            return false;
        }
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

    public function checkLikedComment($postId, $idComment) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM likedcomments WHERE idUser = '.$this->id.' AND idPost = '.$postId.' AND idcomment = '.$idComment.''; // Return the user ID
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

    public function getLikes() { // Return a list with the liked posts
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT LP.idPost, LP.time FROM likedposts LP WHERE '.$_SESSION['user']->id().' = LP.idUser ORDER BY LP.time DESC'; // Return the user
        $rs = $conn->query($sql);
        if ($rs->num_rows > 0) {
            return $rs;
        } else return false;
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

    public function getRepets() { // Return a list with the repeted posts
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT RP.idPost, RP.time FROM repets RP WHERE '.$_SESSION['user']->id().' = RP.idUser ORDER BY RP.time DESC'; // Return the user
        $rs = $conn->query($sql);
        if ($rs->num_rows > 0) {
            return $rs;
        } else return false;
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

    public function likeComment($postId, $idcomment) { // Like a comment (add it to your likedcomments list)
        $app = Aplicacion::getSingleton();
        echo 'verga';
        $conn = $app->conexionBd();
        $sql = 'INSERT INTO likedcomments VALUES ('.$idcomment.', '.$this->id.', '.$postId.')'; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else return false;
    }

    public function unlikeComment($postId, $idcomment) { // Unlike a comment (remove it from your likedcomments list)
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM likedcomments WHERE idUser = '.$this->id.' AND idPost = '.$postId.' AND idComment = '.$idcomment.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else return false;
    }

    public function likedAmount() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM likedcomments WHERE idUser = '.$this->id.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return $result->num_rows;
        } else return false;
    }

	public function repetAmount() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM repets WHERE idUser = '.$this->id.''; // Return the user ID
        $result = $conn->query($sql);
        if ($result) {
            return $result->num_rows;
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

    public function deleteAccount() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM users WHERE id = '.$this->id.'';
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else return false; 
    }

}

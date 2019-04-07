<?php
require_once __DIR__ . '/Aplicacion.php';

class Usuario {

    // Variables

    private $id; // Auto-set
    private $username; // User specified
    private $password; // User specified
    private $fullname; // User specified
    private $email; // User specified
    private $rol; // Admin specified

    private function __construct($username, $fullname, $password, $email, $rol,$id) {
        $this->username= $username;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->email = $email;
        $this->rol = $rol;
        $this->id = $id;
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
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['username'], $fila['fullname'], $fila['password'], $fila['email'], $fila['rol'],$fila['id']);
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
     public static function buscaIdUsuario($username)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT id FROM users WHERE username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $result = $fila;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($username, $fullname, $password, $email, $rol,$id) {
        $user = self::buscaUsuario($username);
        if ($user) {
            return false;
        }
        $user = new Usuario($username, $fullname, self::hashPassword($password), $email, $rol,$id);
        return self::guarda($user);
    }

    public static function buscaMascotas() { // Return all my pets
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $pets = Pet::allPets($conn->real_escape_string($id)); // Look for my pets (with my id)

        return $result;
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
    
    private static function actualiza($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE users U SET username = '%s', fullname='%s', password='%s', email='%s', rol='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->fullname)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $usuario;
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
}

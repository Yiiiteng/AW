<?php

require_once "aplicacion.php";

class Usuario
{

    public static function login($nombreUsuario, $password)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $app = Aplicacion::getSingleton();
        $mysqli = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.Nick_Name = '%s'", $mysqli->real_escape_string($nombreUsuario));
        $rs = $mysqli->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['Nick_Name'], $fila['ID_Usuario'], $fila['Nombre_Usuario'], $fila['Primer_Apellido'], $fila['Segundo_Apellido'], $fila['Imagen_Perfil'], $fila['Fecha_Nacimiento'], $fila['Correo'], $fila['Telefono'], $fila['Test'], $fila['Contrasena'], $fila['Es_Admin']);
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $mysqli->errno . ") " . utf8_encode($mysqli->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($Nick_Name, $ID_Usuario, $Nombre_Usuario, $Primer_Apellido, $Segundo_Apellido, $Imagen_Perfil, $Fecha_Nacimiento, $Correo, $Telefono, $Test, $Contrasena, $Es_Admin)
    {
        $user = self::buscaUsuario($Nick_Name);
        if ($user) {
            return false;
        }
        $user = new Usuario($Nick_Name, $ID_Usuario, $Nombre_Usuario, $Primer_Apellido, $Segundo_Apellido, $Imagen_Perfil, $Fecha_Nacimiento, $Correo, $Telefono, $Test, $Contrasena, $Es_Admin);
        return self::guarda($user);
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function guarda($usuario)
    {
        if ($usuario->ID_Usuario !== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }
    
    private static function inserta($usuario)
    {
        $app = Aplicacion::getSingleton();
        $mysqli = $app->conexionBd();
        $query=sprintf("INSERT INTO usuario(Contrasena, Correo, Es_Admin, Fecha_Nacimiento, Nick_Name, Nombre_Usuario, Primer_Apellido, Segundo_Apellido, Telefono, Test) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $mysqli->real_escape_string($usuario->Contrasena)
            , $mysqli->real_escape_string($usuario->Correo)
            , '0'
            , $mysqli->real_escape_string($usuario->Fecha_Nacimiento)
            , $mysqli->real_escape_string($usuario->Nick_Name)
            , $mysqli->real_escape_string($usuario->Nombre_Usuario)
            , $mysqli->real_escape_string($usuario->Primer_Apellido)
            , $mysqli->real_escape_string($usuario->Segundo_Apellido)
            , $mysqli->real_escape_string($usuario->Telefono)
            , '0');
        if ( $mysqli->query($query) ) {
            $usuario->ID_Usuario = $mysqli->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $mysqli->errno . ") " . utf8_encode($mysqli->error);
            exit();
        }
        return $usuario;
    }
    
    private static function actualiza($usuario)
    {
        $app = Aplicacion::getSingleton();
        $mysqli = $app->conexionBd();
        $query=sprintf("UPDATE Usuarios U SET nombreUsuario = '%s', nombre='%s', password='%s', rol='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->id);
        if ( $mysqli->query($query) ) {
            if ( $mysqli->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $mysqli->errno . ") " . utf8_encode($mysqli->error);
            exit();
        }
        
        return $usuario;
    }
    
    private $Nick_Name;

    private $ID_Usuario;

    private $Nombre_Usuario;

    private $Primer_Apellido;

    private $Segundo_Apellido;

    private $Imagen_Perfil;

    private $Fecha_Nacimiento;

    private $Correo;

    private $Telefono;

    private $Test;

    private $Contrasena;

    private $Es_Admin;



    private function __construct($Nick_Name, $ID_Usuario, $Nombre_Usuario, $Primer_Apellido, $Segundo_Apellido, $Imagen_Perfil, $Fecha_Nacimiento, $Correo, $Telefono, $Test, $Contrasena, $Es_Admin)
    {   
        $this->Nick_Name = $Nick_Name;
        $this->ID_Usuario = $ID_Usuario;
        $this->Nombre_Usuario = $Nombre_Usuario;
        $this->Primer_Apellido = $Primer_Apellido;
        $this->Segundo_Apellido = $Segundo_Apellido;
        $this->Imagen_Perfil = $Imagen_Perfil;
        $this->Fecha_Nacimiento = $Fecha_Nacimiento;
        $this->Correo = $Correo;
        $this->Telefono = $Telefono;
        $this->Test = $Test;
        $this->Contrasena = $Contrasena;
        $this->Es_Admin = $Es_Admin;
    }




    public function ID_Usuario()
    {
        return $this->ID_Usuario;
    }


    public function Nombre_Usuario()
    {
        return $this->Nombre_Usuario;
    }

    public function Primer_Apellido()
    {
        return $this->Primer_Apellido;
    }

    public function Segundo_Apellido()
    {
        return $this->Segundo_Apellido;
    }

    public function Imagen_Perfil()
    {
        return $this->Imagen_Perfil;
    }

    public function Fecha_Nacimiento()
    {
        return $this->Fecha_Nacimiento;
    }

    public function Correo()
    {
        return $this->Correo;
    }

    public function Telefono()
    {
        return $this->Telefono;
    }

    public function Test()
    {
        return $this->Test;
    }

    public function Es_Admin()
    {
        return $this->Es_Admin;
    }

    public function compruebaPassword($password)
    {
        $Contrasena = self::hashPassword($this->Contrasena);
        return password_verify($password, $Contrasena);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }

}

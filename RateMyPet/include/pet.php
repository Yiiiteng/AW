<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Usuario.php';
class Pet{
        private $petName;
        private $petId;
        private $petType;
        private $petBreed;
        private $petDescript;
        private $treats;

     public function __construct ($petName,$petId,$petType,$petBreed,$petDescript,$treats){
        $this->petName = $petName;
        $this->petId = $petId;
        $this->petType = $petType;
        $this->petBreed = $petBreed;
        $this->petDescript = $petDescript;
         $this->treats = $treats;
     }      
      public static function existePet($idOwner,$petName){
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql=sprintf("SELECT petName FROM pets WHERE idOwner = '%s' AND petName = '%s' " 
            ,$idOwner
            ,$connect->real_escape_string($petName));
        $consulta = mysqli_query($connect,$sql);

            if($consulta && $consulta->num_rows == 1) {
                $consulta->free();
                return true;
            }else{
                return false;
            }
    }
    
      public static function buscarPet($idOwner,$petName){
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql=sprintf("SELECT * FROM pets WHERE idOwner = '%s' AND petName = '%s'"
            ,$idOwner
            ,$connect->real_escape_string($petName));

        $consulta = mysqli_query($connect,$sql);
        $result = false;

        if ($consulta) {
            if ( $consulta->num_rows == 1) {
                $fila = $consulta->fetch_assoc();
               // $fruta = new Fruta($fila['id_fruta'], $fila['nombre'],$fila['cantidad'], $fila['precio'],$fila['Oferta']);
                $result = $fila;
            }
            $consulta->free();
        } else {
            echo "Error al consultar en la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
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

     public static function insertar($petName,$petType,$petBreed,$petDescript,$treats){
        
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $query=sprintf("INSERT INTO pets(name,description,type,breed,treats) VALUES('%s', '%s','%s','%s','%s')"
                   , $conn->real_escape_string($petName)
                , $conn->real_escape_string($petType)
                 , $conn->real_escape_string($petBreed)
                , $conn->real_escape_string($petDescript)
                , $conn->real_escape_string($treats));
            if ( $conn->query($query)){
                $petId = $conn->insert_id;
                return true;
            }
             else {
                echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }   
    }

     public static function eliminar($idOwner,$petName){

            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $query=sprintf("DELETE FROM pets where idOwner = '%s' AND petName = '%s'"
                ,$idOwner
                ,$conn->real_escape_string($petName));

            if ( $conn->query($query) ) {
                return true;
            } else {
                echo "Error al eliminar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
    }

    /*public static function actualizar($id_inventario,$datos){

        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $productoBD = self::buscarProducto($id_inventario,$datos['nombre']);


        if ( $datos['precio'] == NULL) {
            $datos['precio'] = $productoBD['precio'];
        }

        if ( $datos['cantidad'] == NULL){
             $datos['cantidad'] = $productoBD['cantidad'];
        }
        
        $sql=sprintf("UPDATE productos SET  cantidad = '%s', precio = '%s' WHERE id_inventario = '%s' AND nombre = '%s'"
            ,$connect->real_escape_string($datos['cantidad'])
            ,$connect->real_escape_string($datos['precio'])
            ,$id_inventario
            ,$connect->real_escape_string($datos['nombre']));

        $consulta = mysqli_query($connect,$sql);

        if($consulta)
            return true;
        else{
            echo "Error al actualizar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
        return false;
        }
    
    }*/
     
     public static function allPets($idOwner){
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql=sprintf("SELECT * FROM pets  WHERE idOwner = '%s'" ,$idOwner);
         $rs = $connect->query($sql);

            if($rs){
                $producto = array();
                while($row =  $rs->fetch_assoc()){
                    $producto[] = $row;
                }
                $rs->free();
                
                return $producto;
                    
            }else {
                    echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
                    exit();
                }


     }
     

         public function petName()
        {
            return $this->petName;
        }

        public function petId()
        {
            return $this->petId;
        }

        public function petType()
        {
            return $this->petType;
        }

        public function petBreed()
        {
            return $this->petBreed;
        }

        public function petDescript()
        {
            return $this->petDescript;
        }

         public function treats()
        {
            return $this->treats;
        }


}
?>
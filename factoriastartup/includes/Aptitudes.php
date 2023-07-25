<?php

namespace es\ucm\fdi\aw;

class Aptitudes{

    private $id_aptitud;
    private $descripcion;

    public function __construct($id_aptitud, $descripcion)
    {
        $this->id_aptitud = $id_aptitud; 
        $this->descripcion = $descripcion;
    }

    public static function obtenerTotalAptitudes(){

        $aptitud = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM aptitudes ORDER BY id_aptitud ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($aptitud,new Aptitudes($fila['id_aptitud'], $fila['descripcion']));
            $fila = $rs->fetch_assoc();

        }       

        return $aptitud;
    }

    public static function obtenerTotalAptitudesDesplegable(){

        $aptitud = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM aptitudes ORDER BY id_aptitud ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($aptitud, $fila);
            $fila = $rs->fetch_assoc();

        }       

        return $aptitud;
    }

    public static function obtenerAptitudPorNum($id_aptitud){

        $aptitudes = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT descripcion FROM aptitudes WHERE id_aptitud = '$id_aptitud'";
        $rs = $conn->query($query);
        
        if ($rs && $rs->num_rows > 0) {
            $fila = $rs->fetch_assoc();
            return $fila['descripcion'];
        } else {
            // Manejar la situación cuando no se encuentra ninguna fila
            // Puedes devolver un valor predeterminado o lanzar una excepción, según tus necesidades.
            return null;
        }
        
    }

    public static function insertaAptitudes($usuario, $aptitudes){
        $result = true;
        $conn = Aplicacion::getInstance()->getConexionBd();

        foreach($aptitudes as $aptitud){
            
            

            $query = sprintf("INSERT INTO rel_usuario_aptitud (id_relacion, id_usuario, id_aptitud) VALUES (NULL, '%s','%s')",
                $conn->real_escape_string($usuario),
                $conn->real_escape_string($aptitud)
            );
            if (!$conn->query($query) ) {
                $result = false;
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }

        }
        return $result;
    }

    public function getIdAptitud(){
        return $this->id_aptitud;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }
}


?>
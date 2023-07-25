<?php

namespace es\ucm\fdi\aw;

class Sector{

    private $descripcion;

    public function __construct($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public static function obtenerTotalSectores(){

        $sectores = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM sectores ORDER BY id_sector ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($sectores,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $sectores;
    }

    public static function obtenerSectorPorNum($id_sector){

        $sectores = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT descripcion FROM sectores WHERE id_sector = '$id_sector'";
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
}


?>
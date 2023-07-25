<?php

namespace es\ucm\fdi\aw;

class BusquedaColaboradores extends Busqueda{

    private $id_proyecto;
    private $id_aptitud;


    public function __construct($id_usuario, $id_proyecto, $porcentaje_empresa, $porcentaje_ventas, $obra_y_servicio, $pacto_a_futuro, $id_aptitud)
    {
        $this->id_proyecto = $id_proyecto;
        $this->id_aptitud = $id_aptitud;

        parent::__construct($id_usuario, $porcentaje_empresa, $porcentaje_ventas, $obra_y_servicio, $pacto_a_futuro);
        
    }

    public function existeBusqueda(){

        //MIRAR SI ESTA BÚSQUEDA YA SE HA REALIZADO Y SE ENCUENTRA EN LA BBDD
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM busqueda_colaboradores WHERE id_usuario = $this->id_usuario AND id_proyecto = $this->id_proyecto AND id_aptitud = $this->id_aptitud;";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila;
    }    

    public static function getIdFromBBDD($usuario, $id_proyecto, $id_aptitud){
        
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM busqueda_colaboradores WHERE id_usuario = $usuario AND id_proyecto = $id_proyecto AND id_aptitud = $id_aptitud;";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila;
    }

    public function insertarBusqueda(){
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO busqueda_colaboradores(id_usuario, id_proyecto, porcentaje_empresa, porcentaje_ventas, obra_y_servicio, pacto_a_futuro, id_aptitud) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($this->id_usuario),
            $conn->real_escape_string($this->id_proyecto),
            $conn->real_escape_string($this->porcentaje_empresa),
            $conn->real_escape_string($this->porcentaje_ventas),
            $conn->real_escape_string($this->obra_y_servicio),
            $conn->real_escape_string($this->pacto_a_futuro),
            $conn->real_escape_string($this->id_aptitud)
        );

        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function getBusquedaColabMatches($id_usuario_proy, $id_proyecto){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $busqueda = array();

        $query = "SELECT *
        FROM busqueda_colaboradores AS busColab
        WHERE busColab.id_aptitud IN (

            SELECT apt.id_aptitud
            FROM busqueda_proyectos AS busProy
            LEFT JOIN rel_usuario_aptitud AS apt
            ON busProy.id_usuario = apt.id_usuario
            WHERE busProy.id_usuario = $id_usuario_proy)

        AND busColab.id_proyecto = $id_proyecto
        AND busColab.id_usuario != $id_usuario_proy
        ;";

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        while ($fila){

            array_push($busqueda,$fila);
            $fila = $rs->fetch_assoc();
        }       
        

        return $busqueda;



    }

    //////////////////SE USA?

    public static function idBusquedaColab($id_match) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $consulta = "SELECT bc.id_proyecto
                    FROM busqueda_colaboradores bc
                    INNER JOIN matches m ON bc.id_busqueda = m.id_busqueda_colab
                    WHERE m.id_match = $id_match";
    
        $resultado = $conn->query($consulta);
        if (!$resultado) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    
        if ($fila = $resultado->fetch_assoc()) {
            $id_proyecto = $fila['id_proyecto'];
            return $id_proyecto;
        }
    
        return null;
    }

}


?>
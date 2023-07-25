<?php

namespace es\ucm\fdi\aw;

class BusquedaProyectos extends Busqueda{

    private $id_proyecto;
    private $mensaje;

    public function __construct($id_usuario, $id_proyecto, $porcentaje_empresa, $porcentaje_ventas,  $obra_y_servicio, $pacto_a_futuro, $mensaje)
    {
        $this->id_proyecto = $id_proyecto;
        $this->mensaje = $mensaje;

        parent::__construct($id_usuario, $porcentaje_empresa, $porcentaje_ventas, $obra_y_servicio, $pacto_a_futuro);
    }

    public function existeBusqueda(){

        //MIRAR SI ESTA BÚSQUEDA YA SE HA REALIZADO Y SE ENCUENTRA EN LA BBDD
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM busqueda_proyectos WHERE id_usuario = $this->id_usuario AND id_proyecto = $this->id_proyecto;";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila;
    }
    

    public function insertarBusqueda(){
        
        //AÑADIR EN LA BBDD NUEVA BÚSQUEDA
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;

            $query = sprintf("INSERT INTO busqueda_proyectos(id_busqueda, id_usuario,id_proyecto,porcentaje_ventas,porcentaje_empresa, obra_y_servicio, pacto_a_futuro, mensaje)  VALUES (NULL, '%s', '%s', '%s', '%s','%s', '%s', '%s')",
                $conn->real_escape_string($this->id_usuario),
                $conn->real_escape_string($this->id_proyecto), 
                $conn->real_escape_string($this->porcentaje_ventas),
                $conn->real_escape_string($this->porcentaje_empresa),
                $conn->real_escape_string($this->obra_y_servicio),
                $conn->real_escape_string($this->pacto_a_futuro),
                $conn->real_escape_string($this->mensaje)
            );

            if ($conn->query($query)) {
                $result = true;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        
        return $result;
    }

    //SELECCIONA TODAS LAS BÚSQUEDA_PROYECTOS CON ESTE ID_PROYECTO SELECCIONADO, CUYO USUARIO TENGA LA APTITUD SELECCIONADA Y QUE EL USUARIO SEA DISTINTO DEL USUARIO DE BÚSQUEDA_COLAB
    public static function getBusquedaProyMatches($id_usuario_busqueda_colab, $id_proyecto, $id_aptitud){
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $proyectos = array();

        $query = "SELECT DISTINCT bus.id_busqueda, bus.id_usuario, bus.id_proyecto, bus.porcentaje_ventas, bus.porcentaje_empresa, bus.obra_y_servicio, bus.pacto_a_futuro
        FROM busqueda_proyectos AS bus
        LEFT JOIN rel_usuario_aptitud AS apt
        ON bus.id_usuario = apt.id_usuario
        WHERE bus.id_proyecto = $id_proyecto
        AND apt.id_aptitud = $id_aptitud 
        AND bus.id_usuario != $id_usuario_busqueda_colab
        ;";

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();
        }       
        

        return $proyectos;
    }

    public static function getIdFromBBDD($usuario, $id_proyecto){
        
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM busqueda_proyectos WHERE id_usuario = $usuario AND id_proyecto = $id_proyecto;";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila;
    }

}



?>
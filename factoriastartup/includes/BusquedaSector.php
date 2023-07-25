<?php

namespace es\ucm\fdi\aw;

class BusquedaSector extends Busqueda{

    private $id_sector;
    private $mensaje; 

    public function __construct($id_usuario, $id_sector, $porcentaje_empresa, $porcentaje_ventas, $obra_y_servicio, $pacto_a_futuro, $mensaje)
    {
        $this->id_sector = $id_sector;
        $this->mensaje = $mensaje;

        parent::__construct($id_usuario, $porcentaje_empresa, $porcentaje_ventas, $obra_y_servicio, $pacto_a_futuro);
   
    }

    public function existeBusqueda(){

        $result = false;
        //MIRAR SI ESTA BÚSQUEDA YA SE HA REALIZADO Y SE ENCUENTRA EN LA BBDD
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM busqueda_sector WHERE id_usuario = $this->id_usuario AND id_sector = $this->id_sector;";
        $rs = $conn->query($query);

        $fila = $rs->fetch_assoc();

        if($fila){
            $result = true;
        }

        return $result;
    }
    

    public function insertarBusqueda(){
        
        //AÑADIR EN LA BBDD NUEVA BÚSQUEDA
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;

            $query = sprintf("INSERT INTO busqueda_sector(id_busqueda, id_usuario, id_sector ,porcentaje_ventas,porcentaje_empresa, obra_y_servicio, pacto_a_futuro, mensaje)  VALUES (NULL, '%s', '%s', '%s', '%s','%s', '%s', '%s')",
                $conn->real_escape_string($this->id_usuario),
                $conn->real_escape_string($this->id_sector), 
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

    //Si existe una busqueda sector de este proyecto, añadimos proyecto en busqueda proyectos
    public static function añadirProyecto($sector, $id_proyecto){
        $result = false;
        $busquedaSector = array();
        //MIRAR SI ESTA BÚSQUEDA YA SE HA REALIZADO Y SE ENCUENTRA EN LA BBDD
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM busqueda_sector WHERE id_sector = $sector;";
        $rs = $conn->query($query);

        $fila = $rs->fetch_assoc();

        if($fila){
            $result = true;
            array_push($busquedaSector,$fila);
        }
        
        foreach ($busquedaSector as $busqueda){

            $BusquedaProyecto = new BusquedaProyectos($busqueda['id_usuario'], $id_proyecto, $busqueda['porcentaje_empresa'], $busqueda['porcentaje_ventas'], $busqueda['obra_y_servicio'], $busqueda['pacto_a_futuro'], $busqueda['mensaje']);
            $BusquedaProyecto->insertarBusqueda();
        }

        return $result;
    }
}



?>
<?php

namespace es\ucm\fdi\aw;

class Eventos
{
    private $id_evento;
    private $evento;
    private $date;
    private $id_proyecto;
    private $id_propietario;
    private $descripcion;


    public function __construct($id_evento, $evento, $date, $id_proyecto, $descripcion, $id_propietario)
{
    $this->id_evento = $id_evento; // Autoincremental en la BD
    $this->evento = $evento;
    $this->date = $date;
    $this->id_proyecto = $id_proyecto;
    $this->descripcion=$descripcion;
    $this->id_propietario=$id_propietario;
}

    
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setPropietario($id_propietario)
    {
        $this->id_propietario = $id_propietario;
    }

    public function getPropietario()
    {
        return $this->id_propietario;
    }
    public function setIdProyecto($id_proyecto)
    {
        $this->id_proyecto = $id_proyecto;
    }

    public function getIdProyecto()
    {
        return $this->id_proyecto;
    }


    public function setIdEvento($id_evento)
    {
        $this->id_evento = $id_evento;
    }

    public function setEvento($evento)
    {
        $this->evento = $evento;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getIdEvento()
    {
        return $this->id_evento;
    }

    public function getEvento()
    {
        return $this->evento;
    }

    public function getDate()
    {
        return $this->date;
    }

    public static function buscaEvento($id_evento)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM eventos WHERE id_evento = %d", $id_evento);
        $rs = $conn->query($query);
        $evento = NULL;
        if ($rs && $rs->num_rows == 1) {
            $fila = $rs->fetch_assoc();
            $evento = new Eventos($fila['evento'], $fila['id_evento'],$fila['fecha'], $fila['id_proyecto'], $fila['descripcion'], $fila['id_propietario']);
            $evento->id_evento = $fila['id_evento'];
        }
        return $evento;
    }

    public static function elimina($id_evento)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $query = sprintf("DELETE FROM eventos WHERE id_evento = %d", $id_evento);

        return $conn->query($query);
    }

    public static function guarda($evento)
    {
        if ($evento->id_evento !== null) {
            return self::actualiza($evento);
        }
        return self::inserta($evento);
    }

    public static function inserta($evento){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf(
            "INSERT INTO eventos(evento, fecha, id_proyecto, descripcion, id_propietario) VALUES('%s', '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($evento->evento),
            $conn->real_escape_string($evento->date),
            $conn->real_escape_string($evento->id_proyecto),
            $conn->real_escape_string($evento->descripcion),
            $conn->real_escape_string($evento->id_propietario)
        );
        if ($conn->query($query)) {
            $evento->id_evento = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $evento;
    }

    public static function obtenerTotalEventosUsuario($idPropietario){

        $eventos = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        //$id_usuario = $_SESSION['id_usuario'];

        $query = "SELECT * FROM eventos WHERE id_propietario = '$idPropietario' ORDER BY id_evento ASC";
        $rs = $conn->query($query);

        $result = array();
        while($fila = $rs->fetch_assoc()) {
            $result[] = new Eventos($fila['evento'], $fila['id_evento'],$fila['fecha'], $fila['id_proyecto'], $fila['descripcion'], $fila['id_propietario']);
        }
    
        $rs->free();
    
        return $result;
    }

    public static function obtenerNumEventosDelUsuario($idUsuario){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT COUNT(*) AS numEventos FROM eventos WHERE id_propietario = $idUsuario";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila['numEventos'];
    }

    public static function actualiza($evento){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf(
            "UPDATE eventos SET evento = '%s', fecha = '%s' WHERE id_evento=%d",
            $conn->real_escape_string($evento->evento),
            $conn->real_escape_string($evento->date),
            $evento->id_evento
        );
        if ($conn->query($query)) {
            if ($conn->affected_rows != 1) {
                echo "No se ha podido actualizar el evento: " . $evento->id_evento;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $evento;
    }
    public static function buscaEventoPorFecha($fecha) {
        
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM eventos WHERE fecha = '%s'", $conn->real_escape_string($fecha));
        $rs = $conn->query($query);
        $evento = NULL;
        if ($rs && $rs->num_rows == 1) {
            $fila = $rs->fetch_assoc();
            $evento = new Eventos($fila['evento'], $fila['id_evento'],$fila['fecha'], $fila['id_proyecto'], $fila['descripcion'], $fila['id_propietario']);
            $evento->id_evento = $fila['id_evento'];
           /* if($evento!=NULL){
             echo $evento->id_evento;
            }*/
        }
       
        return $evento;
    }
    public static function buscaEventoPorNombre($nombre) {
        
    $app = Aplicacion::getInstance();
    $conn = $app->getConexionBd();
    $query = sprintf("SELECT * FROM eventos WHERE evento = '%s'", $conn->real_escape_string($nombre));
    $rs = $conn->query($query);
    $evento = NULL;
    if ($rs && $rs->num_rows == 1) {
        $fila = $rs->fetch_assoc();
        $evento = new Eventos($fila['evento'], $fila['id_evento'],$fila['fecha'], $fila['id_proyecto'], $fila['descripcion'], $fila['id_propietario']);
        $evento->id_evento = $fila['id_evento'];
    }
   
    return $evento;
}

    public static function listaEventos() {
        // Buscamos todos los eventos en la base de datos
        $app = Aplicacion::getInstance();
        $conexion = $app->getConexionBd();
    
        $sql = sprintf("SELECT * FROM eventos ORDER BY id_evento DESC");
    
        $rs = $conexion->query($sql);
    
        $result = array();
        while($fila = $rs->fetch_assoc()) {
            $result[] = new Eventos($fila['evento'], $fila['id_evento'],$fila['fecha'], $fila['id_proyecto'], $fila['descripcion'], $fila['id_propietario']);
        }
    
        $rs->free();
    
        return $result;

    }

    
}
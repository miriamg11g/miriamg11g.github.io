<?php

namespace es\ucm\fdi\aw;
use FFI\Exception;

class Proyecto{

    private $id_proyecto;
    private $id_propietario;
    private $nombre;
    private $sector;
    private $short_description;
    private $description;
    private $needs_description;
    private $idImg;



    public function __construct($id_proyecto, $id_propietario, $nombre, $sector, $short_description, $description, $needs_description, $idImg)
    {
        $this->id_proyecto = $id_proyecto;
        $this->id_propietario = $id_propietario;
        $this->nombre = $nombre;
        $this->sector = $sector;
        $this->short_description = $short_description;
        $this->description = $description;
        $this->needs_description = $needs_description;
        $this->idImg = $idImg;

    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getIdProyecto(){
        return $this->id_proyecto;
    }
    
    
    public static function crearProyecto($id_propietario, $nombre, $sector, $short_description, $description, $needs_description, $idImg){
    
        $proyecto = new Proyecto(NULL, $id_propietario, $nombre, $sector, $short_description, $description, $needs_description, $idImg);
        return self::inserta($proyecto);
    }

    private static function inserta($proyecto)
    {
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO proyectos (id_proyecto, id_propietario, nombre, sector, short_description, description, needs_description , imagen) VALUES (NULL, '%s', '%s', '%s','%s', '%s', '%s', '%s')",
            $conn->real_escape_string($proyecto->id_propietario),
            $conn->real_escape_string($proyecto->nombre),
            $conn->real_escape_string($proyecto->sector),
            $conn->real_escape_string($proyecto->short_description),
            $conn->real_escape_string($proyecto->description),
            $conn->real_escape_string($proyecto->needs_description),
            $conn->real_escape_string($proyecto->idImg)
        );
        if ( $conn->query($query) ) {

            $result = $proyecto;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function obtenerTotalProyectos($sector){

        $proyectos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();

        if($sector == "ALL"){
            $query = "SELECT * FROM proyectos ORDER BY id_proyecto ASC";
        }
        else{
            $query = "SELECT * FROM proyectos WHERE sector=$sector ORDER BY id_proyecto ASC";
        }

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $proyectos;
    }

    public static function obtenerBusquedaProyectos($busqueda){

        $busqueda = ltrim($busqueda, "'");
        $busqueda = rtrim($busqueda, "'");
        $busqueda = '%'.$busqueda.'%';

        $proyectos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();

        if($busqueda == "ALL"){
            $query = "SELECT * FROM proyectos ORDER BY id_proyecto ASC";
        }
        else{
            $query = "SELECT * 
            FROM proyectos 
            WHERE nombre LIKE '$busqueda' 
            OR sector LIKE '$busqueda' 
            OR short_description LIKE '$busqueda' 
            OR description LIKE '$busqueda' 
            OR needs_description LIKE '$busqueda'
            ORDER BY id_proyecto ASC;";
        }

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $proyectos;

    }

    public static function obtenerMisProyectos($idUsuario){
        $proyectos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = "SELECT * FROM proyectos WHERE id_propietario=$idUsuario ORDER BY id_proyecto ASC";

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $proyectos;
    }

    public static function obtenerTotalSectores(){

        $sectores = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT sector, COUNT(*) AS numProyectos FROM proyectos GROUP BY sector;";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($sectores,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $sectores;
    }



    public static function obtenerNumProyectosDelUsuario($idUsuario){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT COUNT(*) AS numProyectos FROM proyectos WHERE id_propietario = $idUsuario";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila['numProyectos'];
    }

    public static function eliminarProyecto($id_proyecto){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "DELETE FROM proyectos WHERE id_proyecto = '$id_proyecto'";
        $rs = $conn->query($query);
    
        if (!$rs) {
            throw new Exception("Error al eliminar el proyecto");
        }
    }

    public static function obtenerProyectosPorId($idProyecto){
        $proyectos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = "SELECT * FROM proyectos WHERE id_proyecto=$idProyecto";

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $proyectos;
    }

    public static function obtenerProyectosPorSector($sector){
        $proyectos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = "SELECT * FROM proyectos WHERE sector=$sector";

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $proyectos;
    }

    public static function getNombreFromId($id_proyecto){
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM proyectos WHERE id_proyecto = $id_proyecto";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila['nombre'];
    }

    public static function getIdFromNombre($nombreProy, $id_usuario){
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM proyectos WHERE nombre = '$nombreProy' AND id_propietario = $id_usuario";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila['id_proyecto'];
    }

/////////LAS FUNCIONES A PARTIR DE AQUÍ NO SÉ SI ESTÁN BIEN//////////////////////



    

    public static function eliminarProyectoPorNombre($nombreProyecto) { //FORMUALRIO NEGOCIADOR ELIMINAR PROYECTO. SE VA A ELIMINAR
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        // Escapamos el nombre del proyecto para evitar inyección de SQL
        $nombreProyecto = $conn->real_escape_string($nombreProyecto);
    
        $query = "DELETE FROM proyectos WHERE nombre = '$nombreProyecto'";
        $rs = $conn->query($query);
    
        if (!$rs) {
            throw new Exception("Error al eliminar el proyecto");
        }
    }


    public static function obtenerTotalProyectosUsuario(){

        $proyectos = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $id_usuario = $_SESSION['id_usuario'];

        $query = "SELECT * FROM proyectos WHERE id_propietario = '$id_usuario' ORDER BY id_proyecto ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $proyectos;
    }

    public static function obtenerIdPorNombreProyecto($nombre){
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT id_proyecto FROM proyectos WHERE nombre = '$nombre'";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
    
        if ($fila) {
            return $fila['id_proyecto'];
        } else {
            return null; // O algún otro valor para indicar que no se encontró el proyecto
        }
    }
    



    public static function obtenerTotalProyectosUsuarioPorId($id_usuario){

        $proyectos = array();

        $conn = Aplicacion::getInstance()->getConexionBd();


        $query = "SELECT * FROM proyectos WHERE id_propietario = '$id_usuario' ORDER BY id_proyecto ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($proyectos,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $proyectos;
    }


    public static function obtenerListaProyectos(){

        $proyectos = array();

        $conn = Aplicacion::getInstance()->getConexionBd();


        $query = "SELECT * FROM proyectos ORDER BY nombre ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila !== null) {
            array_push($proyectos, $fila);
            $fila = $rs->fetch_assoc();
        }       

        return $proyectos;
    }
    
}
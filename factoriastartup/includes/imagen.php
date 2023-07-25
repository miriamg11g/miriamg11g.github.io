<?php

namespace es\ucm\fdi\aw;

class Imagen
{   
    private $Id;
    private $ruta;    
    private $nombre;    
    private $mimeType;
    private $carpeta;    
    const EXTENSIONES_PERMITIDAS = array('jpg','jpeg','png');
        
    private function __construct($ruta, $nombre, $mimeType, $carpeta){
        
        $this->ruta = $ruta;
        $this->nombre = $nombre;
        $this->mimeType = $mimeType;
        $this->carpeta = $carpeta;        
    }

    public static function crea($ruta, $nombre, $mimeType, $carpeta){
        $imagen = new Imagen($ruta, $nombre, $mimeType, $carpeta);
        return $imagen;
    }

    public function guarda(){

        self::inserta($this);
           
        return $this;
    }

    private static function inserta($imagen){//OK

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf(
            "INSERT INTO imagenes (id, ruta, nombre, mimeType, carpeta) VALUES (NULL, '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($imagen->ruta),
            $conn->real_escape_string($imagen->nombre),
            $conn->real_escape_string($imagen->mimeType),
            $conn->real_escape_string($imagen->carpeta)
        );

        $result = $conn->query($query);
        if ($result){

            $imagen->id = $conn->insert_id;
            $result = $imagen;
        }        
        else {
            error_log($conn->error);
        }
        return $result;
    }

    public function cambia(){

        self::actualiza($this);
    
        return $this;
    }

    private static function actualiza($imagen){
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE imagenes I SET ruta = '%s', nombre = '%s', mimeType = '%s' WHERE I.id = %d",
            $conn->real_escape_string($imagen->ruta),
            $conn->real_escape_string($imagen->nombre),
            $conn->real_escape_string($imagen->mimeType),
            $conn->real_escape_string($imagen->id)
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han actualizado '$conn->affected_rows' !");
        }
        

        return $result;
    }

    public static function check_file_uploaded_name($filename){
        return (bool) ((mb_ereg_match('/^[0-9A-Z-_\.]+$/i', $filename) === 1) ? true : false);
    }

    public static function sanitize_file_uploaded_name($filename){
        
        $newName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        $newName = mb_ereg_replace("([\.]{2,})", '', $newName);
        return $newName;
    }

    public static function check_file_uploaded_length($filename){
        return (bool) ((mb_strlen($filename, 'UTF-8') < 250) ? true : false);
    }

    
    public function getIdImagen()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT id FROM imagenes U WHERE U.nombre = '%s'", $conn->real_escape_string($this->nombre));
        $rs = $conn->query($query);
        $idImagen = false;
        if ($rs) {

            $fila = $rs->fetch_assoc();
            if ($fila) {
                $idImagen = $fila['id'];
                
            }
            $rs->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $idImagen; 
    }

    /*

    public static function getExtension($idImagen){

        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT mimeType FROM imagenes U WHERE U.id = '%s'", $conn->real_escape_string($idImagen));
        $rs = $conn->query($query);
        $extImagen = false;
        if ($rs) {

            $fila = $rs->fetch_assoc();
            if ($fila) {
                $extImagen = $fila['mimeType'];
                
            }
            $rs->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $extImagen; 

    }*/

    public function getRuta(){
        return $this->ruta;
    }

    public static function getRutaFromBBDD($idImagen)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT ruta FROM imagenes U WHERE U.id = '%s'", $conn->real_escape_string($idImagen));
        $rs = $conn->query($query);
        $ruta = false;
        if ($rs) {

            $fila = $rs->fetch_assoc();
            if ($fila) {
                $ruta = $fila['ruta'];
                
            }
            $rs->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $ruta;

    }

    public function setRuta($nuevaRuta)
    {
        $this->ruta = $nuevaRuta;
        
    }

    public function getCarpeta()
    {
        return $this->carpeta;
    }



}
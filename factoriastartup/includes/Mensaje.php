<?php

namespace es\ucm\fdi\aw;

require_once __DIR__.'/config.php';

class Mensaje {
    private $conn;
    private $titulo;
    private $autor;
    private $contenido;
    private $id;
    private $fecha;
    private$id_Padre;

    public function __construct() {
        $app = Aplicacion::getInstance();
        $this->conn = $app->getConexionBd();
    }
   

    public function obtenerMensajesHijo($padre){
            
        $sql = "SELECT * FROM mensajes WHERE id_padre = ".$padre." ORDER BY fecha ASC";
        /*".$padre['id']."*/ 
        $rs = $this->conn->query($sql);
        
        $result = array();
        while($fila = $rs->fetch_assoc()) {
                    $result[] =$fila;
        }
        
         return $result;
    }

    public function obtenerMensajeporId($id) {
        $sql = "SELECT * FROM mensajes WHERE id=".$id."  ORDER BY fecha DESC";
        $rs = $this->conn->query($sql);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if(!$fila) return false;
           
        }
        return $fila;

    }

    public function autorMensaje($autor) {
        $sql = "SELECT * FROM mensajes WHERE autor = ".$autor."";
        $result = $this->conn->query($sql);
        $idPadre = null;
        if ($result && $result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $idPadre = $fila['id_padre'];
        }
        return $idPadre;

    }





    public function obtenerMensajesPadre() {
        $sql = "SELECT * FROM mensajes WHERE id_padre=0 ORDER BY fecha DESC";
        $rs = $this->conn->query($sql);
        $mensajes = array();
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $mensajes[] = $fila;
            }
        }   
    return $mensajes;
    }
    


    public function obtenerTodosTitulo() {
        $respuestas = array();
        $sqlRespuestas = "SELECT titulo FROM mensajes ORDER BY fecha ASC";
        $rsRespuestas = $this->conn->query($sqlRespuestas);
        if ($rsRespuestas) {
            while ($filaRespuesta = $rsRespuestas->fetch_assoc()) {
                $respuestas[] = $filaRespuesta;
            }
        }
        return $respuestas;
    }

    public function saberIdPadre($id) {
        $sql = "SELECT id_padre FROM mensajes WHERE id = ".$id."";
        $result = $this->conn->query($sql);
        $idPadre = null;
        if ($result && $result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $idPadre = $fila['id_padre'];
        }
        return $idPadre;

    }

    public function obtenerRespuestas($idPadre) {
        $respuestas = array();
        $sqlRespuestas = "SELECT * FROM mensajes WHERE id_padre = ".$idPadre." ORDER BY fecha DESC";
        $rsRespuestas = $this->conn->query($sqlRespuestas);
        if ($rsRespuestas) {
            while ($filaRespuesta = $rsRespuestas->fetch_assoc()) {
                $respuestas[] = $filaRespuesta;
            }
        }
        return $respuestas;
    }
    

    public function obtenerMostrarMensajes() {
        $mensajes = array();
        $sql = "SELECT * FROM mensajes WHERE id_padre=0 ORDER BY fecha DESC";
        $rs = $this->conn->query($sql);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $mensajes[] = $fila;
            }
        }
        foreach ($mensajes as $fila) {
            echo '<div class="mensaje">';
            echo '<h3>'.$fila['titulo'].'</h3>';
            echo '<p>Por '.$fila['autor'].' el '.$fila['fecha'].'</p>';
            echo '<p>'.$fila['contenido'].'</p>';
            echo '</div>';
        }
    }
    

    public function enviarMensaje($titulo, $contenido, $idPadre = null) {
        $autor = $_SESSION['nombreUsuario'];
        $fecha = date("Y-m-d H:i:s");
        $sql = sprintf("INSERT INTO mensajes (titulo, contenido, autor, fecha, id_padre) VALUES('%s', '%s', '%s', '%s', '%s')"
            , $this->conn->real_escape_string($titulo)
            , $this->conn->real_escape_string($contenido)
            , $this->conn->real_escape_string($autor)
            , $this->conn->real_escape_string($fecha)
            , $this->conn->real_escape_string($idPadre));
        $this->titulo=$titulo;
        $this->contenido=$contenido;
        $this->autor=$autor;
        $this->fecha=$fecha;
        $this->id_Padre=$idPadre;
        return $this->conn->query($sql);
       
    }
    public function getTitulo() {
        return $this->titulo;
    }

    public function getId() {
        return $this->id;
    }

    public function getAutor() {
        return $this->autor;
    }
    public function getPadre() {
        return $this->id_Padre;
    }

    public function getContenido() {
        return $this->contenido;
    }



    public function getFecha() {
        return $this->fecha;
    }

}

/*<?php
namespace es\ucm\fdi\aw;

class Mensaje
{
    
    public static function buscaMensaje($id_mensaje)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM mensajes WHERE id = '%d'", $conn->real_escape_string($id_mensaje));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $mensaje = new Mensaje($fila['id'], $fila['id_padre'], $fila['autor'], $fila['fecha'], $fila['contenido'],$fila['titulo']);
                $mensaje->id_mensaje = $fila['id'];
                $result = $mensaje;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    

    public static function listaMensajesPadre()
    {
        $app = Aplicacion::getInstance();
        $conexion = $app->getConexionBd();
        
        $sql = "SELECT * FROM mensajes WHERE id_padre IS NULL ORDER BY fecha DESC";
        $rs = $conexion->query($sql);
        
        
        $result = array();
        while($fila = $rs->fetch_assoc()) {
            $result[] = new Mensaje($fila['id'], $fila['id_padre'], $fila['autor'], $fila['fecha'], $fila['contenido'],$fila['titulo']);
        }
        
        $rs->free();
        
         return $result;
    }
    public static function listaMensajesHijo($hijo)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        
        $sql = "SELECT * FROM mensajes WHERE id_padre = ".$hijo['id']." ORDER BY fecha ASC";
        $rs = $conn->query($sql);
        
        
        $result = array();
        while($fila = $rs->fetch_assoc()) {
                    $result[] = new Mensaje($fila['id'], $fila['id_padre'], $fila['autor'], $fila['fecha'], $fila['contenido'],$fila['titulo']);
        }
        
        $rs->free();
        
         return $result;
    }

    public static function elimina($id_mensaje) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $query = sprintf("DELETE FROM mensajes WHERE id_mensaje = '%d'", $id_mensaje);
    
        return $conn->query($query);
    }
    
    /*
    public static function crea($id_mensaje)
    {
        $mensaje = new Mensaje($id_mensaje);
        return self::guarda($mensaje);
    }
    
    public static function guarda($mensaje)
    {
        if ($mensaje->id_mensaje !== null) {
            return self::actualiza($mensaje);
        }
        return self::inserta($mensaje);
    }
    
    public static function inserta($autor,$titulo, $contenido, $idPadre, $fecha){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $sql = sprintf("INSERT INTO mensajes (id_padre, autor, contenido, titulo, fecha) VALUES('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($idPadre)
            , $conn->real_escape_string($autor)
            , $conn->real_escape_string($fecha)
            , $conn->real_escape_string($contenido)
            , $conn->real_escape_string($titulo));
        
        ;
        mysqli_query($conn, $sql);

        if ( $conn->query($sql) ) {
            $creo = $conn->insert_id;

        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        } 
        return $creo;
    }
    
   /* private static function actualiza($mensaje)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query=sprintf("UPDATE mensajes SET id= '%s', id_padre='%s', autor='%s', fecha='%s', contenido='%s', titulo='%s' WHERE id=%i"
            , $conn->real_escape_string($mensaje->id_padre)
            , $conn->real_escape_string($mensaje->autor)
            , $conn->real_escape_string($mensaje->fecha)
            , $conn->real_escape_string($mensaje->contenido)
            , $conn->real_escape_string($mensaje->titulo));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la mensaje: " . $mensaje->id_mensaje;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $mensaje;
    }

    
    public static function getMensaje($id){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM mensajes WHERE id = '%d'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $mensaje = mysqli_fetch_assoc($rs);

        return $mensaje;
    }
    
   


    
//Variables

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private $id_mensaje;

    private $id_padre;

    private $autor;

    private $fecha;

    private $contenido;

    private $titulo;


    
    private function __construct($id_mensaje = null, $autor, $contenido, $titulo, $fecha, $id_padre = null)
    {
        $this->id_mensaje = $id_mensaje !== null ? intval($id_mensaje) : null;
        $this->autor = intval($autor);
        $this->contenido = $contenido;
        $this->titulo = $titulo;
        $this->fecha = $fecha;
        $this->id_padre = $id_padre !== null ? intval($id_padre) : null;
    }
     

    public function id_mensaje()
    {
        return $this->id_mensaje;
    }

    public function id_padre()
    {
        return $this->id_padre;
    }

    public function autor()
    {
        return $this->autor;
    }

    public function fecha()
    {
        return $this->fecha;
    }

    public function contenido()
    {
        return $this->contenido;
    }

    public function titulo()
    {
        return $this->titulo;
    }
    
}

*/
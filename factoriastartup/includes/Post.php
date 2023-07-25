<?php

namespace es\ucm\fdi\aw;
use FFI\Exception;

class Post{

    private $idPropietario;
    private $titulo;
    private $short_description;
    private $descripcion;
    private $imagen;

    public function __construct( $idPropietario, $titulo, $short_description, $descripcion, $imagen)
    {
        $this->idPropietario= $idPropietario;
        $this->titulo = $titulo;
        $this->short_description = $short_description;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
    }

    ////////GETTERS Y SETTERS////////////////////////////////////////////////////////////////

    /*public function getIdPost(){
        return $this->id_post;
    }*/

    public function getTitulo(){
        return $this->titulo;
    }

    public function getShortdescripcion(){
        return $this->short_description;
    }

    public function getdescripcion(){
        return $this->descripcion;
    }
    public function getImagen(){
        return $this->imagen;
    }


    /*public function setIdPost($id_post){
        $this->id_post = $id_post;
    }*/

    ///////FUNCIONES///////////////////////////////////////////////////////////////////

    public static function crearPost($idPropietario, $titulo, $short_description, $descripcion, $imagen) {

        $post = new Post($idPropietario, $titulo, $short_description, $descripcion, $imagen);

        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO posts (id_post, id_propietario, titulo, short_description, descripcion, imagen) VALUES (NULL, '$idPropietario', '$titulo', '$short_description', '$descripcion', '$imagen')",
            $conn->real_escape_string($post->idPropietario),
            $conn->real_escape_string($post->titulo),
            $conn->real_escape_string($post->short_description),
            $conn->real_escape_string($post->descripcion),
            $conn->real_escape_string($post->imagen)
        );
        if ( $conn->query($query) ) {

            $result = $post;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;

    }

    public static function obtenerTotalPosts(){

        $posts = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM posts ORDER BY id_post ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        while ($fila){

            array_push($posts,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $posts;
    }

    public static function obtenerTotalPostsUsuario($idPropietario){

        $posts = array();

        $conn = Aplicacion::getInstance()->getConexionBd();

        //$id_usuario = $_SESSION['id_usuario'];

        $query = "SELECT * FROM posts WHERE id_propietario = '$idPropietario' ORDER BY id_post ASC";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        while ($fila){

            array_push($posts,$fila);
            $fila = $rs->fetch_assoc();

        }       

        return $posts;
    }

    public static function obtenerBusquedaPosts($busqueda){

        $busqueda = ltrim($busqueda, "'");
        $busqueda = rtrim($busqueda, "'");
        $busqueda = '%'.$busqueda.'%';

        $post = array();
        $conn = Aplicacion::getInstance()->getConexionBd();

        if($busqueda == "ALL"){
            $query = "SELECT * FROM posts ORDER BY id_post ASC";
        }
        else{
            $query = "SELECT * 
            FROM posts 
            WHERE descripcion LIKE '$busqueda' 
            OR short_description LIKE '$busqueda' 
            OR titulo LIKE '$busqueda' 
            ORDER BY id_post ASC;";
        }

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila){

            array_push($post,$fila);
            $fila = $rs->fetch_assoc();
        }       

        return $post;

    }

    public static function eliminarPost($id_post){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "DELETE FROM posts WHERE id_post = '$id_post'";
        $rs = $conn->query($query);
    
        if (!$rs) {
            throw new Exception("Error al eliminar el post");
        }
    }

    public static function obtenerNumPostDelUsuario($idUsuario){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT COUNT(*) AS numPost FROM posts WHERE id_propietario = $idUsuario";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila['numPost'];
    }



    ///////////////////////SE USA?
    

    public static function eliminarPostPorTitulo($tituloPost) {
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Escapamos el título del post para evitar inyección de SQL
        $tituloPost = $conn->real_escape_string($tituloPost);

        $query = "DELETE FROM posts WHERE titulo = '$tituloPost'";
        $rs = $conn->query($query);

        if (!$rs) {
            throw new Exception("Error al eliminar el post");
        }
    }

    public static function modificarPostPorTitulo($tituloPost, $nuevoTitulo, $nuevaDescripcion) {
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Escapamos los títulos de los posts para evitar inyección de SQL
        $tituloPost = $conn->real_escape_string($tituloPost);
        $nuevoTitulo = $conn->real_escape_string($nuevoTitulo);

        // Si la descripción está vacía, la dejamos como estaba
        if (empty($nuevaDescripcion)) {
            $query = "UPDATE posts SET titulo = '$nuevoTitulo' WHERE titulo = '$tituloPost'";
        } else {
            $nuevaDescripcion = $conn->real_escape_string($nuevaDescripcion);
            $query = "UPDATE posts SET titulo = '$nuevoTitulo', descripcion = '$nuevaDescripcion' WHERE titulo = '$tituloPost'";
        }

        $rs = $conn->query($query);

        if (!$rs) {
            throw new Exception("Error al modificar el post");
        }
    }

    public static function buscaPost($id_post){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM posts WHERE id_post = %d", $id_post);
        $rs = $conn->query($query);
        $post = NULL;
        if ($rs && $rs->num_rows == 1) {
            $fila = $rs->fetch_assoc();
            $post = new Post($fila['id_post'], $fila['descripcion'], $fila['short_description'], $fila['titulo'],$fila['imagen']);
            //$post->setIdPost($fila['id_post']);
        }
        return $post;
    }

}

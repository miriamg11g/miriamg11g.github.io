<?php
namespace es\ucm\fdi\aw;

class Usuario
{
    private $nombre;
    private $apellido;
    private $nombre_usuario;
    private $correo;
    private $password;
    private $rol;
    private $img;
    private $descripcion_aptitudes;
    private $aptitudes;

    private function __construct($nombre, $apellido, $nombre_usuario, $correo, $password, $img)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nombre_usuario= $nombre_usuario;
        $this->correo = $correo;
        $this->password = $password;
        $this->rol = 'user';
        $this->img = $img;
        
    }


//REGISTRO Y LOGIN ////////////////////////////////////////////////////////////////////////

        public static function crea($nombre, $apellido, $nombreUsuario, $correo, $password, $aptitudes)
        {
            $usuario = self::buscaUsuario($nombreUsuario);
            if ($usuario) {
                return false; // User already exists
            }
            
            $usuario = new Usuario($nombre, $apellido, $nombreUsuario, $correo, self::hashPassword($password), 'user');
            
            self::inserta($usuario);

            return Aptitudes::insertaAptitudes(self::buscaIdUsuarioCorreo($correo), $aptitudes);
            
        }

    

    private static function inserta($usuario)
    {
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO usuarios (id_usuario, nombre, apellido, ubicacion, nombre_usuario , correo, clave,  rol) VALUES (NULL, '%s','%s',NULL, '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($usuario->nombre),
            $conn->real_escape_string($usuario->apellido),
            $conn->real_escape_string($usuario->nombre_usuario),
            $conn->real_escape_string($usuario->correo),
            $conn->real_escape_string($usuario->password),
            $conn->real_escape_string($usuario->rol)
        );
        if ( $conn->query($query) ) {

            $result = $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    

    public static function login($correo, $password)
    {        
        //Me devolverá el usuario en caso de que exista
        $usuario = self::buscaUsuario($correo);
        
            if ($usuario && $usuario->compruebaPassword($password, $usuario->password)) {
                
                $_SESSION['nombreUsuario'] = $usuario->nombre_usuario;
                
                return true;
                
            }        
        return false;
    }

    public static function buscaUsuario($correo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM usuarios U WHERE U.correo = '%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $usuario=null;
        if ($rs) {

            $fila = $rs->fetch_assoc();
            if ($fila) {
                $usuario = new Usuario($fila['nombre'], $fila['apellido'], $fila['nombre_usuario'], $fila['correo'], $fila['clave'], $fila['imagen'], $fila['descripcion_aptitudes']);
                
            }
            $rs->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $usuario; 
    }

    public static function buscaIdUsuarioCorreo($correo)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT id_usuario FROM usuarios WHERE correo = '%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ($rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $result = $fila['id_usuario'];
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function buscaIdUsuario($nombreUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nombre_usuario = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $idUsuario = false;
        if ($rs) {

            $fila = $rs->fetch_assoc();
            if ($fila) {
                $idUsuario = $fila['id_usuario'];
                
            }
            $rs->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $idUsuario; 
    }

    public static function buscaUsuarioCorreo($correo)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT nombre_usuario FROM usuarios WHERE correo = '%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ($rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $result = $fila['nombre_usuario'];
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    

    public static function buscaInfoUsuario($idUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM usuarios U WHERE U.id_usuario = '%s'", $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        $idUsuario = false;
        if ($rs) {

            $fila = $rs->fetch_assoc();
            if ($fila) {


                $idUsuario = new Usuario($fila['nombre'], $fila['apellido'], $fila['nombre_usuario'], $fila['correo'], $fila['clave'], $fila['imagen']);

            }
            $rs->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $idUsuario; 
    }

    public static function buscaNombreUsuarioPorId($idUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM usuarios U WHERE U.id_usuario = '%s'", $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        $idUsuario = false;
        $rs = $conn->query($query);
        $idUsuario = false;
        if ($rs) {
            if ($rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $idUsuario = $fila['nombre_usuario'];
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $idUsuario; 
    }


    public static function update($id_usuario, $nombre, $apellido, $nombreUsuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $nombre = $conn->real_escape_string($nombre);
        $apellido = $conn->real_escape_string($apellido);
        $nombreUsuario = $conn->real_escape_string($nombreUsuario);
       
        $query = sprintf("UPDATE usuarios 
        SET nombre = '$nombre',
        apellido = '$apellido',
        nombre_usuario = '$nombreUsuario'
        WHERE id_usuario=$id_usuario");

        if ( $conn->query($query) ) {


        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

//CONTRASEÑAS////////////////////////////////////////////////////////////////////////////////
    public function compruebaPassword($password1,$password2)
    {
        return password_verify($password1,$password2);
    
        //return $password1 == $password2;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }


//NO SÉ SI FUNCIONAN/////////////////////////////////////////////////////////////////////////
    
    

    public static function guarda($usuario) //NO SE USA!!
    {
        /*if ($usuario->id !== null) {
            return self::actualiza($usuario);
        }*/
        return self::inserta($usuario);
    }


    public static function buscaUsuarioo($nombre_usuario)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nombre_usuario = '%s'", $conn->real_escape_string($nombre_usuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['id_usuario'], $fila['nombre'], $fila['apellido'], $fila['desripcion_aptitudes'], $fila['ubicacion'], $fila['nombre_usuario'], $fila['correo'], $fila['clave'], $fila['descripcion_aptitudes']);
                //$user->id = $fila['id_usuario'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result ; 
    }
    
    
    
   
    
    
    
    private static function actualiza($usuario)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query=sprintf("UPDATE usuarios U SET nombreUsuario = '%s', correo='%s', password='%s', rol='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $usuario;
    }


    public static function comprobarAdmin($idUsuario){
        
        $usuario = self::buscaUsuario($idUsuario);
    
        // Verifica si el usuario existe y tiene el rol de "admin"
        if($usuario && $usuario->getRol() == 'admin'){
            return true;
        } else {
            return false;
        }
    }
/*
    public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexion();
        $query = sprintf("SELECT * FROM credenciales WHERE idUsuario=%d", $idUsuario);
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if(!$fila) return false;
            $user = new Usuario( $fila['nombreUsuario'],$fila['correo'],$fila['clave'], $fila['rol']);
            $rs->free();

            return $user;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    */

    public static function modificarPuntos($puntos, $id)
    {
        $result = false;

        $conn = Aplicacion::getInstance()->getConexion();
        $query=sprintf("UPDATE usuarios U SET puntos='%d' WHERE U.idUsuario=%d"
        , $puntos
        , $id
        );

        if ( $conn->query($query) ) {
            $result = true;
            
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
    public static function modificarCuenta($cuentaActiva, $id){
        
        $result = false;

        $conn = Aplicacion::getInstance()->getConexion();
        $query=sprintf("UPDATE usuarios U SET cuentaActiva='%s' WHERE U.idUsuario=%d"
        , $cuentaActiva
        , $id
        );

        if ( $conn->query($query) ) {
            $result = true;
            
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }

    

    public static function getUsuario($correo){
        $app = Aplicacion::getInstance();
        $conexion = $app->getConexionBd();

        
        $consulta = "SELECT * FROM usuarios WHERE nombre_usuario = '$correo'";
        $resultado = mysqli_query($conexion, $consulta);
        $usuario = mysqli_fetch_assoc($resultado);

        return $usuario;
    }


    public static function eliminarUsuarioViaje($id_usuario, $id_viaje){
        $app = Aplicacion::getInstance();
        $conexion = $app->getConexionBd();

        $consulta = "DELETE FROM usuarios_viajes WHERE id_usuario = '" . $id_usuario . "' AND id_viaje = '" . $id_viaje . "'";
        mysqli_query($conexion, $consulta);
    }


    public static function guardaInfo($correo, $usuario){
        $app = Aplicacion::getInstance();
        $conexion = $app->getConexionBd();

        $consulta= "UPDATE usuarios SET correo='$correo' WHERE nombreUsuario='$usuario'";

        mysqli_query($conexion, $consulta);

    }
    
    public static function guardaContrasena($contrasena, $usuario){
        $app = Aplicacion::getInstance();
        $conexion = $app->getConexionBd();

        $consulta= "UPDATE usuarios SET clave='$contrasena' WHERE nombreUsuario='$usuario'";

        mysqli_query($conexion, $consulta);

    }
    
    
///GETTERS Y SETTERS /////////////////////////////////////////////////////////////////////////////
 
    public function getRol()
    {
        return $this->rol;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    /*
    public function getDescripcionAptitudes(){

        return $this->descripcionAptitudes;
    }*/
    public function getNombreUsuario()
    {
        return $this->nombre_usuario;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getAptitudes()
    {
        return $this->descripcion_aptitudes;
    }
    public function setAptitudes($descripcion_aptitudes)
    {
        $this->aptitudes = $descripcion_aptitudes;
    }
    public function getCompruebaPassword($clave)
    {
        return $clave ===$this->password;
    }

    public function getCambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }

    public function getImg(){
        return $this->img;
    }
}

<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => 'inicio.php', 'enctype'=> 'multipart/form-data']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $apellido = $datos['apellido'] ?? '';
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $correo = $datos['correo'] ?? '';
       
        // Se generan los mensajes de error si existen.
        /*$htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
        $errorApellido = self::createMensajeError($errores, 'apellido', 'span', array('class' => 'error'));
        $errorNombreUsuario = self::createMensajeError($errores, 'nombreUsuario', 'span', array('class' => 'error'));
        $errorCorreo = self::createMensajeError($errores, 'correo', 'span', array('class' => 'error'));
        $errorclave = self::createMensajeError($errores, 'clave', 'span', array('class' => 'error'));
        $errorclave2 = self::createMensajeError($errores, 'clave2', 'span', array('class' => 'error'));

        */

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellido', 'nombreUsuario', 'correo', 'clave', 'clave2'], $this->errores, 'span', array('class' => 'error'));

        $htmlDesplegableAptitudes = self::generaDesplegableAptitudes2();
        
        $html = <<<EOF
        <div class="contact_form">
            $htmlErroresGlobales
            <div class="formulario">      
                <h3>Datos personales</h3>
                    
                    <p class="aviso">
                    <span class="obligatorio"> * </span>Los campos son obligatorios.
                    </p> 
                       
                    <input type="text" name="nombre" required="obligatorio" placeholder="Nombre*" value="$nombre" />
                    {$erroresCampos['nombre']}

                    <input type="text" name="apellido" required="obligatorio" placeholder="Apellidos*" value="$apellido" />
                    {$erroresCampos['apellido']}

                    <input type="text" name="nombreUsuario" required="obligatorio" placeholder="Nombre de usuario*" value="$nombreUsuario" />
                    {$erroresCampos['nombreUsuario']}

                    <input type="text" name="correo" required="obligatorio" placeholder="Correo electrónico*" value="$correo" />
                    {$erroresCampos['correo']}

                    <input type="password" name="clave" required="obligatorio" placeholder="Nueva contraseña*" />
                    {$erroresCampos['clave']}

                    <input type="password" name="clave2" required="obligatorio" placeholder="Repita su contraseña*" />
                    {$erroresCampos['clave2']}

                    <label for="opciones">Aptitudes:</label>
                    $htmlDesplegableAptitudes
                    

                    <!--<label><input type="checkbox" id="cbox" value="cbox"> Marque esta casilla para verificar que ha leído nuestros términos y condiciones de servicio
                    <span class="obligatorio">*</span>
                    </label>-->

                    <div class="botonn">
                    <button type="submit" name="registro">Regístrate</button>
                    </div>
                             
                </form>

                    
            </div>  
                    
        </div>
    EOF;
    return $html;
    }
    

    protected function procesaFormulario(&$datos){
        
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $this->errores['nombre'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }

        $apellido = trim($datos['apellido'] ?? '');
        $apellido = filter_var($apellido, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($apellido) || mb_strlen($apellido) < 5 ) {
            $this->errores['apellido'] = "El apellido tiene que tener una longitud de al menos 5 caracteres.";
        }

        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
            $this->errores['nombreUsuario'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($correo) || mb_strlen($correo) < 5 ) {
            $this->errores['correo'] = "El correo electrónico tiene que tener una longitud de al menos 5 caracteres.";
        }
        if(!str_contains($correo, '@')){
            $this->errores['correo'] = "El correo debe tener el siguiente formato: ejemplo@ejemplo.com";
        }
        
        $password = $datos['clave'] ?? null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $this->errores['clave'] = "La contraseña tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = $datos['clave2'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $this->errores['clave2'] = "Las contraseñas deben coincidir";
        }
        
        //$aptitudes = $datos['aptitud'] ?? [];
        // ...
        //if (empty($aptitudes)) {
        //   $this->errores['aptitud'] = 'No ha seleccionado ninguna aptitud.';
        //}

    
        

        /*foreach ($datos['opciones'] as $opcion) {
            echo $opcion . "<br>";
        }*/

        $aptitudes = array();

        $i = 0;
        while(isset($datos['opciones'][$i])){
                        
            $opcion = $datos['opciones'][$i];
            array_push($aptitudes, $opcion);

            $i++;

        }
  
        

        if (count($this->errores) === 0) {
            $usuario = Usuario::crea($nombre, $apellido, $nombreUsuario, $correo, $password, $aptitudes);
            if (!$usuario) {
                $this->errores['correo'] = "El correo electrónico ya está asociado a otra cuenta.";
            } else {
              
                $_SESSION['login'] = true;
                $_SESSION['id_usuario'] = Usuario::buscaIdUsuarioCorreo($correo);
                $_SESSION['nombreUsuario'] = Usuario::buscaUsuarioCorreo($correo);
            }
        }
        
    }
    public function generaDesplegableAptitudes() {
        $i=0;
        $aptitudes = Aptitudes::obtenerTotalAptitudes();
        $numfilas = sizeof($aptitudes);
        $html = '<div class="divDesplegable">';
        while ($numfilas > $i) {
            $fila = $aptitudes[$i];
            $id = $fila['id_aptitud'];
            $nombre = $fila['descripcion'];
            $html .= '<input type="checkbox" name="aptitud[]" id="aptitud_' . $id . '" value="' . $id . '">';
            $html .= '<label for="aptitud_' . $id . '">' . $nombre . '</label><br>';
            $i = $i + 1;
        }
        $html .= '</div>';
        return $html;
    }

    public function generaDesplegableAptitudes2(){

        $aptitudes = Aptitudes::obtenerTotalAptitudes();

        $html = <<<EOF
                <div class="form-container">
            EOF;


        $i = 0;
        foreach ($aptitudes as $aptitud) {

            //$aptitud = new Aptitudes($apt['id_aptitud'], $apt['descripcion']);
            $id_aptitud = $aptitud->getIdAptitud();
            $descripcion =  $aptitud->getDescripcion();


        $html.= <<<EOF

                <div class="linea"> 
                    <div class="titulo">$descripcion</div> 
                    <input type="checkbox" id="opcion . $i" name="opciones[]" value="$id_aptitud">
                </div>
            EOF;

        }

        $html.= <<<EOF
            </div>
            EOF;

        return $html;

        }

    }


<?php
namespace es\ucm\fdi\aw;

class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'inicio.php', 'enctype'=> 'multipart/form-data']);
    }
    
    protected function generaCamposFormulario(&$datos) //, $errores = array()
{   
   
        $correo = $datos['correo'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['correo', 'password'], $this->errores, 'span', array('class' => 'error'));
       
    
        $html = <<<EOF
        <div class="contact_form">            
            <div class="formulario">      
                <h3>Inicio de sesión</h3>                           
                                     
                    <input type="varchar" name="correo" id="correo" required="obligatorio" placeholder="Correo electrónico*" onblur="usuarioComprobar()">
                    <span class="correo" id="usuario-noexiste"></span>
                    {$erroresCampos['correo']}
                    
                    <input type="password" name="clave" id="clave" style="width: 408px" required="obligatorio" placeholder="Contraseña*" onblur="claveComprobar()">
                    <span class="clave" id="clave-contraseña"></span>
                    {$erroresCampos['password']}   
                    
                    <div class="botonn">
                    <button type="submit" name="inicioSesion">Iniciar Sesión</button>
                    </div>              
                    
                    $htmlErroresGlobales

                </form>
            </div>         
        </div>

    EOF;
    return $html;
}

    protected function procesaFormulario(&$datos){
        
        $this->errores=[];

        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$correo || empty($correo)){
            $this->errores['correo'] = "El correo no puede estar vacío";
        }
        if(!str_contains($correo, '@')){
            $this->errores['correo'] = "El correo debe tener el siguiente formato: ejemplo@ejemplo.com";
        }
        
        $clave = trim($datos['clave'] ?? '');
        $clave = filter_var($clave, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$clave || empty($clave)){
            $this->errores['password'] = "La contraseña no puede estar vacía";
        }

        if(count($this->errores)===0){

            $result = Usuario::login($correo, $clave);
            $id_usuario=Usuario::buscaIdUsuarioCorreo($correo);
            if(!$result){

                $this->errores[] = "ERROR. Usuario o contraseña no encontrados";
            }            
            else{
                $_SESSION['login'] = true;
                $_SESSION['id_usuario'] = $id_usuario;
                
                if(Usuario::comprobarAdmin($id_usuario)){
                    $_SESSION['admin']=true;
                }
                //if(Usuario::comprobarAdmin($nombreUsuario)){
                //    $_SESSION['admin']=true;
                //}

            }         
        }        
    }
}

?>



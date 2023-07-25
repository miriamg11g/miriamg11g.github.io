<?php
namespace es\ucm\fdi\aw;

require_once __DIR__.'/config.php';
require_once __DIR__ . '/Usuario.php';

class FormularioForoContinua extends Formulario{
    private $id;

    public function __construct($id) {
        parent::__construct('formForoContinua', ['urlRedireccion' => 'foroContinua.php?id=' . $id, 'id' => 'formForoContinua']);
        $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos, $errores = array()) {
       
       $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
       $erroresCampos = self::generaErroresCampos(['titulo', 'contenido'], $errores, 'span', ['class' => 'error']);
       $id_usuario = Usuario::buscaIdUsuario($_SESSION['nombreUsuario']);

       $mensajeError = '';
        if (in_array("Por favor, completa todos los campos. Debe escribir tanto un título, como el contenido del mensaje del que quiere hablar.", $this->errores)) {
            $mensajeError = '<span class="error">Por favor, completa todos los campos. Debe escribir tanto un título, como el contenido del mensaje del que quiere hablar.</span>';
        }else if(in_array("Error al insertar el mensaje en la base de datos.", $this->errores)) {
            $mensajeError = '<span class="error">Error al insertar el mensaje en la base de datos.</span>';
        }

        //cogemos el id de la parte que se pasa
        $id=isset($_GET['id']) ? $_GET['id'] : '';
        
        $mensajes = new Mensaje();
        //array con todos los mensajes hijos dando el idPadre
        $mens = $mensajes->obtenerMensajesHijo($id);
        //obtener el padre dandole el id
        $padre = $mensajes->obtenerMensajeporId($id);
        $usuario = Usuario::buscaUsuario($padre['autor']);
        
        $html = '';
        $html='<div class="foroContinuo"><br><br>';

        $html.= self::generarPadre($padre, $usuario);
        
        $mensajeError;
       
        $html.='<div class="foroRespuesta">';
        $html.='<br>';
            $html.=self::respuestas($padre);
            $html.='<div class="mensajeHijoForoContinuo">';
            foreach($mens as $mensajitos){
                $html.='<div class="hijo">';
                $html.=self::respuestas($mensajitos);
                $html.='</div>';
            }
            $html.='</div>';
        $html.='</div>';

       $html.=self::responderMensaje();
       $html.='</div>';
       
        return $html;
    }



    public function generarPadre($padre, $usuario){
        //enseñar mensaje principal del padre
        
        $html= '<div class= "mensajePadre">';
            $html.= '<div class= "mensajePadrefecha">';
                $html .= '<p class="tituloPadre">' . $padre['autor'] . '</p>';
                $html .= '<p class="fechaPadrep">'. $padre['fecha'] . '</p>';
        // $html.= '<div class= "foto">   <img src="img/iconosUsuario/' . $usuario->getIcono() . '.png" width="100" height="100" alt="Foto de perfil del participante"></div>';
            $html .= '</div>';
            $html.= '<div class= "mensajeP">';
                $html .= '<h2><strong>' . $padre['titulo'] . '</strong> </h2>';
            $html .= '</div>';
            $html .= '<div class= "contenidoForoPadre">';
                $html .= '<p class="contenidoPadre"> ' . $padre['contenido'] . '</p>';
            $html .= '</div>';  
           
        $html .= '</div>';

        
        return $html; 

    }

    public function respuestas($mensaje){
            
        $respuestaHijo=new Mensaje();
       
                // Obtener respuestas para este mensaje
        
        $respuestas = $respuestaHijo->obtenerRespuestas($mensaje['id']);
     
       
        $html ='';
            foreach ($respuestas as $respuesta) {
                $usuario = Usuario::buscaUsuario($respuesta['autor']);
              
                $html .= '<div class= "mensajeHijo">';
                    $html .= '<div class= "mensajeHijofecha">';
                    $html .= '<p>' . $respuesta['autor'] . '</p>';
                    $html .= '<p class="fechap">' . $respuesta['fecha'] . '</p>';
                    //$html.= '<div class= "foto">   <img src="img/iconosUsuario/' . $usuario->getIcono() . '.png" width="65" height="65" alt="Foto de perfil del participante"></div>';
                $html .= '</div>';
    
                $html .= '<div class= "contenidoForoHijo">';
                $html .= '<p> ' . $respuesta['contenido'] . '</p>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<br>';
            }
            return $html;
    }

    
    public function responderMensaje() {
        
          // Formulario para crear un nuevo mensaje
          $html = '<br>';
          $html .= '<div class="respuestaForo">';
          $html .= '<h2>Añadir mensaje</h2>';
          $html .= '<label for="titulo">Título del mensaje:</label>';
          $html .= '<input type="text" id="titulo" required="obligatorio" name="titulo"><br>';
          $html .= '<label for="contenido">Contenido:</label>';
          $html .= '<textarea id="contenido" required="obligatorio" name="contenido"></textarea>';
          $html .= '<input type="submit" name="enviar" value="Enviar mensaje" id="enviarMensaje"><br></br>';
          $html .= '</div>';
  
        return $html;
    }
    


    
protected function procesaFormulario(&$datos) {

    $result = array();
    $titulo = isset($datos['titulo']) ? htmlspecialchars(trim(strip_tags($datos['titulo']))) : null;
    $contenido = isset($datos['contenido']) ? htmlspecialchars(trim(strip_tags($datos['contenido']))) : null;
    $fecha = date("Y-m-d H:i:s");

    if ( empty($titulo) || empty($contenido) ) {
        $result['errores'] = "Por favor, completa todos los campos. Debe escribir tanto un título, como el contenido del mensaje del que quiere hablar.";
    } else {
       // echo $datos;
            // Aquí se guarda el mensaje en la base de datos
        $mensaje = new Mensaje();

        
        $idPadre=$this->id;
        $idNuevoMensaje = $mensaje->enviarMensaje($titulo, $contenido, $idPadre);
        if ( $idNuevoMensaje === false ) {
            $result['errores'] = "Error al insertar el mensaje en la base de datos.";
        } else {
            $result['success'] = "Mensaje enviado correctamente.";
        }
    }


    return $result;
    
    
}

}
?>



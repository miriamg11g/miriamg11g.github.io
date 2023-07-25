<?php
namespace es\ucm\fdi\aw;

require_once __DIR__.'/config.php';

class FormularioForo extends Formulario{
    public function __construct() {
        parent::__construct('formForo', ['urlRedireccion' => 'foro.php']);
    }
    
    protected function generaCamposFormulario(&$datos, $errores = array()) {
        $mensajeError = '';
        if (in_array("Por favor, completa todos los campos.", $this->errores)) {
            $mensajeError = '<span class="error">Por favor, completa todos los campos.</span>';
        }
    
        
        $html = '';
        // Aquí se muestra el listado de mensajes y se permite responder a ellos
        $html .= '<div class="foro">';
        
        $html.=self::crearMensaje();
        $mensajeError;
        $mensajes = new Mensaje();
        $mens = $mensajes->obtenerMensajesPadre();
        
        $html .= '<div class="temas">';
        $html .= '<h3>Temas actuales</h3>';
        foreach ($mens as $mensaje) {
            $html .= '<div class= "mensajePadre"> ';
            $html .= '<a href="foroContinua.php?id= ' . $mensaje['id'] . '"><p><span style="float: left;">' . $mensaje['titulo'] . '</span><div style="float: right;"><a href="foroContinua.php?id= ' . $mensaje['id'] . '"><img src="img/flechaDerecha.png" style="width: 15px; height: 10px;"></a></div></p></a>';
            $html .= '</div>';                     
        }


        /*$html.=self::responderMensaje();*/
                      
        
                       
        $html .= '</div>';

        return $html;
        
    }

    

    /*public function respuestas($mensaje){
        $respuestaHijo=new Mensaje();
    
            // Obtener respuestas para este mensaje
            $respuestas = $respuestaHijo->obtenerRespuestas($mensaje['id']);
            foreach ($respuestas as $respuesta) {
                $html = '<div class= "mensajeHijo">';
                $html .= '<p><strong>Titulo respuesta:</strong> ' . $respuesta['titulo'] . '</p>';
                $html .= '<p><strong>Autor respuesta:</strong> ' . $respuesta['autor'] . '</p>';
                $html .= '<p><strong>Fecha respuesta:</strong> ' . $respuesta['fecha'] . '</p>';
                $html .= '<div class= "contenidoForoHijo">';
                $html .= '<p><strong>Contenido respuesta:</strong> ' . $respuesta['contenido'] . '</p>';
                $html .= '</div>';
                $html .= '</div>';
            }
        return $html;
    }*/

    public function crearMensaje() {

        // Formulario para crear un nuevo mensaje
        $html = '<div class="crearMensaje">';
        $html .= '<h2>Publicar tema de conversación</h2>';
        $html .= '<label for="titulo">Título del tema a tratar:</label>';
        $html .= '<input type="text" id="titulo" required="obligatorio" name="titulo"><br></br>';
        $html .= '<label for="contenido">¿Qué te gustaría comentar?</label>';
        $html .= '<textarea id="contenido" name="contenido" required="obligatorio"></textarea><br>';
        $html .= '<input type="submit" name="enviar" value="Enviar mensaje">';
        $html .= '</div>';

        return $html;

    }
    
   

protected function procesaFormulario(&$datos) {
    $result = array();

    
    $titulo = isset($datos['titulo']) ? htmlspecialchars(trim(strip_tags($datos['titulo']))) : null;
    $contenido = isset($datos['contenido']) ? htmlspecialchars(trim(strip_tags($datos['contenido']))) : null;
    $idPadre = isset($datos['id_padre']) ? htmlspecialchars(trim(strip_tags($datos['id_padre']))) : null;
    $fecha = date("Y-m-d H:i:s");

    if ( empty($titulo) || empty($contenido) ) {
        $result['errores'] = "Por favor, completa todos los campos.";
    } else {
            // Aquí se guarda el mensaje en la base de datos
        $mensaje = new Mensaje();

        $user = $_SESSION['nombre'];
        $autor = $_SESSION['nombre'];
        $idNuevoMensaje = $mensaje->enviarMensaje($titulo, $contenido, 0);
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
            

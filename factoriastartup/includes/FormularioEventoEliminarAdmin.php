<?php
namespace es\ucm\fdi\aw;

require_once __DIR__.'/Formulario.php';

class FormularioEventoEliminarAdmin extends Formulario {

    public function __construct() {
        parent::__construct('formEliminarEvento');
    }

    
    protected function generaCamposFormulario(&$datosIniciales) {
    
        $mensajeError = '';
        if (in_array("No se ha encontrado un evento con el nombre especificado.", $this->errores)) {
            $mensajeError = '<span class="error">No se ha encontrado un evento con el nombre especificado.. Vuélvelo a intentar</span>';
        }else if(in_array("No se ha podido eliminar el evento.", $this->errores)) {
            $mensajeError = '<span class="error">No se ha podido eliminar el evento.</span>';
        }
     
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['sector'], $this->errores, 'span', array('class' => 'error'));
    

        $htmlDesplegableSectores = self::generaDesplegableEventos();
        
        $nombreEvento = $datosIniciales['sector'] ?? '';
        $html = <<<EOF
        <div class="FormularioCrear">
            <div class="contact_form">
            <h2>Eliminar un evento</h2>
                <br></br>
                    <label>Nombre del evento:</label>
                    {$mensajeError}
                    $htmlDesplegableSectores
                    <input class="evento" type="submit" value="Eliminar evento" />
            </div>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores=[];
        
        $nombreEvento = trim($datos['sector'] ?? '');
        $nombreEvento = filter_var($nombreEvento, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if (count($this->errores) === 0) {
            $evento = Eventos::buscaEventoPorNombre($nombreEvento);
            var_dump($evento);
            if ( !$evento ) {
                 $this->errores[]= "No se ha encontrado un evento con el nombre especificado.";
            } else {
                echo"si";
                if (Eventos::elimina($evento->getIdEvento())) {
                    $this->errores[] = "Evento eliminado correctamente.";
                    header('Location: calendarioMostrarAdmin.php');

                } else {
                    $this->errores[] = "No se ha podido eliminar el evento.";
                }
            }
        }
        
        
    }

    public function generaDesplegableEventos(){
        $listaEventos = Eventos::listaEventos();
    
        $numfilas = sizeof($listaEventos);
    
        $html = '<div class="divDesplegable"> <select class="input" name="sector" id="sector" required>';   
        $html .= '<option hidden class="desplegable" selected>Selecciona el evento</option>';	
    
        foreach ($listaEventos as $evento) {
            $id = $evento->getEvento();
            $nombre = $evento->getIdEvento();
            $date = $evento->getDate();
            
            
            
            $html .= '<option value="' . $nombre . '">' .$nombre. "(". $date . ")" .'</option>';	
        } 
    
        $html .= '</select> </div>';
    
        return $html;        
    }
    
}
?>

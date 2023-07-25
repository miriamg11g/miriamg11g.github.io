<?php

namespace es\ucm\fdi\aw;

require_once __DIR__.'/Formulario.php';

class FormularioEventoModificarAdmin extends Formulario {


    public function __construct() {
        parent::__construct('formModificarEvento', ['action' => '', 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datosIniciales) {
        
        $mensajeError = '';
        if (in_array("Debes seleccionar una fecha para el evento.", $this->errores)) {
            $mensajeError = '<span class="error">Debes seleccionar una fecha para el evento.</span>';
        }else if(in_array("No se ha podido modificar el evento.", $this->errores)) {
            $mensajeError = '<span class="error">No se ha podido modificar el evento.</span>';
        }
     
        
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['sector'], $this->errores, 'span', array('class' => 'error'));
        

        $htmlDesplegableSectores = self::generaDesplegableEventos();
        
        
        $nombreEvento = $datosIniciales['sector'] ?? '';
        $fechaEvento = $datosIniciales['fechaEvento'] ?? '';
        $html = <<<EOF
        <div class="FormularioCrear">
            <div class="contact_form">
                <h2>Modificar evento</h2>
                    <br></br>
                    <label>Nombre del evento:</label>
                    {$mensajeError}
                    $htmlDesplegableSectores
                    
                    <label>¿Cuál quiere que sea la nueva fecha del evento?</label>
                    <input type="date" name="fechaEvento" value="$fechaEvento" />

                    <input class="evento" type="submit" value="Modificar evento" />
            </div>
        </div>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $result = array();
    
        $nombreEvento = $datos['sector'] ?? null;
        $fechaEvento = $datos['fechaEvento'] ?? null;
    
           
        if ( empty($fechaEvento) ) {
            $result['fechaEvento'] = "Debes seleccionar una fecha para el evento.";
        }
    
        if (count($result) === 0) {
            $evento = Eventos::buscaEventoPorNombre($nombreEvento);
            if (!$evento) {
                $result[] = "El evento que intentas modificar no existe.";
            } else {
                $evento->setEvento($nombreEvento);
                $evento->setDate($fechaEvento);
                $evento->setIdEvento($evento->getIdEvento());
                $evento = Eventos::actualiza($evento);
                if (!$evento) {
                    $result[] = "No se ha podido modificar el evento.";
                } else {
                    $result[] = "Modificado el evento.";
                    header('Location: calendarioMostrarAdmin.php');
                }
            }
        }
    
    
        return $result;
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

    

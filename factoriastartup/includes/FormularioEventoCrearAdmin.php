<?php

namespace es\ucm\fdi\aw;

require_once __DIR__.'/Formulario.php';


class FormularioEventoCrearAdmin extends Formulario {

    public function __construct() {
        parent::__construct('formCrearEvento', ['action' => '', 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datosIniciales) {
        
        $mensajeError = '';
        if (in_array("No se ha podido crear el evento", $this->errores)) {
            $mensajeError = '<span class="error">No se ha podido crear el evento. Vuélvelo a intentar</span>';
        }else if(in_array("No se ha podido eliminar el evento.", $this->errores)) {
            $mensajeError = '<span class="error">No se ha podido eliminar el evento.</span>';
        }else if(in_array("El nombre del evento debe tener al menos 5 caracteres.", $this->errores)) {
            $mensajeError = '<span class="error">El nombre del evento debe tener al menos 5 caracteres.</span>';
        }else if(in_array("Debes seleccionar una fecha para el evento.", $this->errores)) {
            $mensajeError = '<span class="error">Debes seleccionar una fecha para el evento.</span>';
        }else if(in_array("Debes escribir una descripción.", $this->errores)) {
            $mensajeError = '<span class="error">Debes escribir una descripción.</span>';
        }
       
        
        $nombreEvento = $datosIniciales['nombreEvento'] ?? '';
        $fechaEvento = $datosIniciales['fechaEvento'] ?? '';
        $descripcion = $datosIniciales['descripcion'] ?? '';

        //$id_usuario = Usuario::buscaIdUsuario($_SESSION['nombreUsuario']);

        
        $htmlDesplegableSectores = self::generaDesplegableEventos();
        $html = <<<EOF
        <div class="FormularioCrear">
        
            <div class="contact_form">
            
            <h2>Crea un nuevo evento</h2>
                    <br></br>
                    <label>Nombre del evento:</label>
                    
                    <input type="text" name="nombreEvento" placeholder="Escribe el nombre que deseas poner" value="$nombreEvento" />

                    <label>Descripcion del evento:</label>
                    <input type="text" name="descripcion" placeholder="Escribe la descripcion que deseas poner" value="$descripcion" />

                    <label class="input">El evento que quieres crear pertenece al proyecto: </label>
                    $htmlDesplegableSectores
                    {$mensajeError}

                    <label>Fecha del evento:</label>
                    <input type="date" name="fechaEvento" value="$fechaEvento" />

                    <div class="botonn">
                    <button type="submit" value="Crear evento" />Crear evento</button>
                    </div>
                    

            </div>
        </div>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $result = array();
        
        $idProyecto=trim($datos['id_proyecto'] ?? '');
        $nombreEvento = $datos['nombreEvento'] ?? null;
        $fechaEvento = $datos['fechaEvento'] ?? null;
        $descripcion= $datos['descripcion']??null;
        $usuario=$_SESSION['id_usuario'];
        var_dump($idProyecto);
        
        var_dump($descripcion);
        if ( empty($nombreEvento) || mb_strlen($nombreEvento) < 5 ) {
            $this->errores['nombreEvento'] = "El nombre del evento debe tener al menos 5 caracteres.";
        }

        if ( empty($fechaEvento) ) {
            $this->errores['fechaEvento'] = "Debes seleccionar una fecha para el evento.";
        }

        if ( empty($descripcion) ) {
            $this->errores['descripcion'] = "Debes escribir una descripción.";
        }
        $intento = Eventos::buscaEventoPorNombre($nombreEvento);
        if (!$intento) {
            

            if (count($this->errores) === 0) {
                $evento = new Eventos(null, $nombreEvento, $fechaEvento,$idProyecto,$descripcion, $usuario);
            $evento = Eventos::inserta($evento);
            if ( !$evento ) {
                $result[] = "No se ha podido crear el evento.";
            } else {
                $result[] = "Creado el evento.";
                header('Location: calendarioMostrarAdmin.php');
            }
        }

        

        return $result;
        }
    }


    public function generaDesplegableEventos(){
        $listaProyectos = Proyecto::obtenerListaProyectos();
       
        $numfilas = sizeof($listaProyectos);
    
        $html = '<div class="divDesplegable"> <select class="input" name="id_proyecto" id="sector" required>';   
        $html .= '<option hidden class="desplegable" selected>Selecciona el evento</option>';	
    
        foreach ($listaProyectos as $fila) {
            $id_proyecto = $fila['id_proyecto'];
            $nombre = $fila['nombre'];
    
            $html .= '<option value="' . $id_proyecto . '">' .$nombre. " (".$id_proyecto.")". '</option>';	
        } 
    
        $html .= '</select> </div>';
    
        return $html;        
    }
    

}
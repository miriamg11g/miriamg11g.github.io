<?php
namespace es\ucm\fdi\aw;

class FormularioNegociadorUsuario extends Formulario
{

    private $id_proyecto;

    public function __construct($id_proyecto) {

        $this->id_proyecto = $id_proyecto;

        parent::__construct('formUsuario', [ 'action' => '', 'enctype' => 'multipart/form-data']);
    }
    
    

    protected function generaCamposFormulario(&$datos)
    {

        $erroresCampos = self::generaErroresCampos(['porcentajeEmpresa','porcentajeVentas', 'errorGlobal'], $this->errores, 'span', array('class' => 'error'));
        $htmlDesplegableAptitudes = self::generaDesplegableAptitudes();

        $html = <<<EOF
            <div class="contact_form">
                <div class="titulo">
                <h1>Selecciona el porcentaje que ofreces en esta negociación</h1>
                    <div class="contenedor">
                        <div class="porcVentas">
                            <p>Porcentaje empresa:</p>
                            <input class ="control" type="number" name="porcentajeEmpresa" id="porcentajeEmpresa" placeholder="Selecciones un porcentaje numérico" >
                            {$erroresCampos['porcentajeEmpresa']}
                        </div>    
                        <div class="porcVentas">
                            <p>Porcentaje de ventas o beneficios:</p>
                            <input class ="control" type="number" name="porcentajeVentas" id="porcentajeVentas" placeholder="Selecciones un porcentaje numérico" >
                            {$erroresCampos['porcentajeVentas']}
                        </div>
                        <div class="porcVentas">
                            <p>Por obra y servicio</p>
                            <select name="obrayservicio" id="obrayservicio">
                                <option value="1">Sí</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                        <div class="porcVentas">
                            <p>Pacto a futuro</p>
                            <select name="pactoAFuturo" id="pactoAFuturo">
                                <option value="1">Sí</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                    </div>
                        <div class="contenedor">
                            <div class="porcVentas">
                                <p>Selecciona el tipo de perfil que necesitas para tu proyecto</p>
                                $htmlDesplegableAptitudes
                            </div>
                        </div>
                    <div class="botonNeg"><button class= "envio" type="submit"name="negociar">Negociar</button></div>
                    {$erroresCampos['errorGlobal']}
                </div>
            </div>
        EOF;

        return $html;
    }
    

    protected function procesaFormulario(&$datos){

        $porcentajeEmpresa = trim($datos['porcentajeEmpresa'] ?? '');
        $porcentajeEmpresa = filter_var($porcentajeEmpresa, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $porcentajeVentas = trim($datos['porcentajeVentas'] ?? '');
        $porcentajeVentas = filter_var($porcentajeVentas, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $mensaje = trim($datos['mensaje'] ?? '');
        $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $obrayservicio = trim($datos['obrayservicio'] ?? '');
        $obrayservicio = filter_var($obrayservicio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $pactoAFuturo = trim($datos['pactoAFuturo'] ?? '');
        $pactoAFuturo = filter_var($pactoAFuturo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $aptitud = trim($datos['aptitud'] ?? '');
        if (!$aptitud) {
            $this->errores['aptitud'] = 'No ha seleccionado ninguna aptitud.';
        }

        if ( empty($porcentajeEmpresa)) {
            $this->errores['porcentajeEmpresa'] = "Debes seleccionar el porcentaje de la empresa que ofreces.";
        }

        if ( empty($porcentajeVentas) ) {
            $this->errores['porcentajeVentas'] = "Debes seleccionar el porcentaje de las ventas que ofreces.";
        }

        $BusquedaColaboradores = new BusquedaColaboradores($_SESSION['id_usuario'], $this->id_proyecto,$porcentajeEmpresa, $porcentajeVentas, $obrayservicio, $pactoAFuturo, $aptitud);

        $existe = $BusquedaColaboradores->existeBusqueda();

        if ($existe) {
            $this->errores['errorGlobal'] = "La negociación con ese tipo de colaborador ya existe.";
        }
        
        if (count($this->errores) === 0) {

            $intento = $BusquedaColaboradores->insertarBusqueda();
            
            if($intento){

                //PRIMERO HACER UN BUCLE PARA TODAS LAS BÚSQUEDA_PROYECTOS CON ESTE ID_PROYECTO SELECCIONADO, CUYO USUARIO TENGA LA APTITUD SELECCIONADA Y QUE EL USUARIO SEA DISTINTO AL USUARIO DE BÚSQUEDA_COLAB
                $busquedas_proyectos = BusquedaProyectos::getBusquedaProyMatches($_SESSION['id_usuario'], $this->id_proyecto, $aptitud);

                foreach($busquedas_proyectos as $busqueda_proyecto){

                    //EXTRAER EL ID DE LA BUSQUEDA DE BUSQUEDA COLAB
                    $busqueda_colab = BusquedaColaboradores::getIdFromBBDD($_SESSION['id_usuario'], $this->id_proyecto, $aptitud);
                    
                    //MIRAR SI YA EXISTE MATCH PARA ESA COMBINACIÓN DE BÚSQUEDA_COLAB Y BÚSQUEDA_PROY
                    $existeMatch = Matches::existe_match($busqueda_colab['id_busqueda'], $busqueda_proyecto['id_busqueda']);
                    
                    //MIRAR SI CUMPLE LOS CRITERIOS PARA HACER MATCH
                    $cumpleCriteriosMatch = Matches::analizarSiMatch($busqueda_colab, $busqueda_proyecto);

                    //SI EL MATCH NO EXISTE Y SE CUMPLEN LOS CRITERIOS PARA HACER MATCH
                    if(!$existeMatch && $cumpleCriteriosMatch){
                        //HACER MATCH
                        $match = Matches::hacer_match($busqueda_colab, $busqueda_proyecto);

                        if($match){

                            //SACAR POR PANTALLA EL POPUP
                            $nombreUser = Usuario::buscaNombreUsuarioPorId($busqueda_proyecto['id_usuario']);
                            $nombreProyecto = Proyecto::getNombreFromId($busqueda_proyecto['id_proyecto']);

                            $mensaje = "El usuario " . $nombreUser . " está interesado en colaborar en tu proyecto ". $nombreProyecto;
                            
                            $popup = new MatchPopUp("¡Has hecho match!", $mensaje, $busqueda_colab['id_busqueda'], $busqueda_proyecto['id_busqueda']);
                            $popup->show();
                            
                        }

                    }
                }            
            }
        }
        
        //return $result;

    }

    public function generaDesplegableAptitudes(){


        $listaAptitudes = Aptitudes::obtenerTotalAptitudesDesplegable();

        $numfilas = sizeof($listaAptitudes);

        $id = 0;
        $i = 0;

        $html = '<div class="divDesplegable"> <select class="input" name="aptitud" id="aptitud" required>';   
        $html .= '<option hidden class="desplegable" selected>Selecciona una aptitud</option>';	

        while($numfilas > $i){

            $fila = $listaAptitudes[$i];

            $id = $fila['id_aptitud'];

            $nombre = $fila['descripcion'];

            $html .= '<option value="' . $id . '">' . $nombre . '</option>';	

            $i = $i + 1;
        } 

		$html .= '</select> </div>';

        return $html;
    }


}



       

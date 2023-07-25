<?php
namespace es\ucm\fdi\aw;

class FormularioBusquedaProyectoPorSector extends Formulario
{

    public function __construct() {
       parent::__construct('formBusqueda2', ['action' => '', 'enctype' => 'multipart/form-data']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $sector = $datos['sector'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['sector'], $this->errores, 'span', array('class' => 'error'));
                
        //Código desplegable sectores
        $htmlDesplegableSectores = self::generaDesplegableSectores();


        $html = <<<EOF
        $htmlErroresGlobales
        <div class="datos">
            <div class="marco">
                $htmlErroresGlobales
                <div>
                    <button class="boton" type="submit" name="buscar">Buscar por Sector</button>
                </div>
                <div >
                    <br></br>
                    <label class="input">Escoje el sector en el que estás interesado: </label>
                    <br></br>
                    $htmlDesplegableSectores
                    {$erroresCampos['sector']}
                </div>
            </div>
        </div>           
       
    EOF;
    return $html;
    }
    

    protected function procesaFormulario(&$datos){

        $this->errores = [];

        $sector = trim($datos['sector'] ?? '');
        //$sector = filter_var($sector, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$sector) {
            $this->errores['sector'] = 'No ha seleccionado ningún sector.';
        }

        //header("Location: trabajo.php?sector=$sector");

        if($sector==NULL){
            $this->errores[] = "No se ha podido crear.";
        } else {
            $_SESSION['sector'] =  $sector;
            $this->errores[] = "Creado.";
            header('Location: busquedaSector2.php');
            
        }
    }
        
    

    public function generaDesplegableSectores(){


        $listaSectores = Sector::obtenerTotalSectores();

        $numfilas = sizeof($listaSectores);

        $id = 0;
        $i = 0;

        $html = '<div class="divDesplegable"> <select class="input" name="sector" id="sector" required>';   
        $html .= '<option hidden class="desplegable" selected>Selecciona un sector</option>';	

        while($numfilas > $i){

            $fila = $listaSectores[$i];

            $id = $fila['id_sector'];

            $nombre = $fila['descripcion'];

            $html .= '<option value="' . $id . '">' . $nombre . '</option>';	

            $i = $i + 1;
        } 

		$html .= '</select> </div>';

        return $html;
    }

}


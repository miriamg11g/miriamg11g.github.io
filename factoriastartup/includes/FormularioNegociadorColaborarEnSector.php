<?php
namespace es\ucm\fdi\aw;

class FormularioNegociadorColaborarEnSector extends Formulario
{

    public function __construct() {
       parent::__construct('formBusqueda', ['enctype'=> 'multipart/form-data']);
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
                    <div >
                    $htmlDesplegableSectores
                    {$erroresCampos['sector']}
                    <div>
                    <button class="boton" type="submit" name="buscar">Buscar por Sector</button>
                    </div>
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
        else{        
            header("Location: negociadorProcesarBusquedaColaborarPorSector.php?sector=$sector");
        }
       
        //$_SESSION['sector'] = $sector;
        
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


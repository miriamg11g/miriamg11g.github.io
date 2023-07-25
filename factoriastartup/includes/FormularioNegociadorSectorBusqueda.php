<?php
namespace es\ucm\fdi\aw;

class FormularioNegociadorSectorBusqueda extends Formulario
{
    public function __construct()
    {
        parent::__construct('formBuscador', ['enctype'=> 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $sector = $datos['sector'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['sector'], $this->errores, 'span', array('class' => 'error'));

        $htmlDesplegableSectores = self::generaDesplegableSectores();

        
        $html = <<<EOF
            <div class="filtro">
                $htmlDesplegableSectores     
                <div>
                    <button class="boton" type="submit" name="buscar">Buscar</button>
                </div>
                   
            {$erroresCampos['sector']}
            </div>
        EOF;

    return $html;
    }


    protected function procesaFormulario(&$datos){
        
        $this->errores = [];

        $sector = trim($datos['sector'] ?? '');
        if (!$sector) {
            $this->errores['sector'] = 'No ha seleccionado ningún sector.';
        }

        if (count($this->errores) === 0) {            
            header("Location: negociadorBusquedaColaborar.php?sector='$sector'");
        }              
    }

    public function generaDesplegableSectores(){


        $listaSectores = Sector::obtenerTotalSectores();

        $numfilas = sizeof($listaSectores);

        $id = 0;
        $i = 0;

        $html = '<div class="divDesplegable"> <select class="input" name="sector" id="sector" required>';   
        $html .= '<option hidden class="desplegable"  selected>Filtrar por sector</option>';	

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
    

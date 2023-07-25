<?php
namespace es\ucm\fdi\aw;

class FormularioPostBusqueda extends Formulario
{
    public function __construct()
    {
        parent::__construct('formBuscador', ['enctype'=> 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $busqueda = $datos['busqueda'] ?? '';
        

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['busqueda'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
            $htmlErroresGlobales
            <div class="buscador">                          
                    
                <input type="text" name="busqueda" placeholder="Ingresa tu búsqueda" value="$busqueda" required>
                {$erroresCampos['busqueda']}
                
                <button type="submit">Buscar</button>
                                             
                </form>                    
            </div>                      
        EOF;

    return $html;
    }


    protected function procesaFormulario(&$datos){
        
        $this->errores = [];

        $busqueda = trim($datos['busqueda'] ?? '');
        $busqueda = filter_var($busqueda, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($busqueda)) {
            $this->errores['busqueda'] = "La búsqueda no puede estar vacía";
        }

        if (count($this->errores) === 0) {            
            header("Location: postBusqueda.php?busqueda='$busqueda'");
        }              
    }
}
    

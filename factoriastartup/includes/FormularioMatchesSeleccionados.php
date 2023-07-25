<?php
namespace es\ucm\fdi\aw;


class FormularioMatchesSeleccionados extends Formulario
{

    private $id_match;
    private $listaMatches;

    public function __construct(&$datos) {
        parent::__construct('formBusqueda', ['urlRedireccion' => 'index.php']);
     }

    protected function generaCamposFormulario(&$datos){
         //$match = $datos['match'] ?? '';
         
         
         //$htmlMatchesConfirmados = self::generaMatchesConfirmados();
 
 


        $this->listaMatches = $datos['listaMatches'];
        $this->id_match = $datos['id_match'];
       

        $fila = $this->listaMatches[$this->id_match];

        $id_match = $fila['id_match'];
        $confirmado = $fila['confirmado'];
        $descripcion = $fila['descripcion'];
        $nombre = $fila['id_busqueda_proy'];
        $id_propietario = $fila['id_busqueda_colab'];
            

        //Hacer que visualmente se vean las descripciones de los proyectos etc.
            
        $html = <<<EOF

        <div class= titulo-container> <h1 class="titulo">$nombre</h1> </div>
        <div class= descripcion-container><p class="descripcion"> $descripcion</p></div>
        <div class=botones-container>
            <td> <a class="editar" href="procesarAceptarMatch.php?Matches={$id_match}">Contactar</a><span>
        </div>
        

        EOF;


    return $html;
    }

    //SE USA?
    public function generaMatchesConfirmados(){


        $listaMatches = Matches::obtenerTotalMatchesConfirmados();
        
        $numfilas = sizeof($listaMatches);

        $i = 0;

        $html = '<div class="boxes">';   
        

       while($numfilas > $i){

            $fila = $listaMatches[$i];

            $id_match = $fila['id_match'];
            $confirmado = $fila['confirmado'];
            $descripcion = $fila['descripcion'];
            $nombre = $fila['id_busqueda_proy'];
            $id_propietario = $fila['id_busqueda_colab'];

            //Hacer que visualmente se vean las descripciones de los proyectos etc.
            $html = '<div class="caja">'; 
           
            $html .= '<h1 class="titulo">' . $nombre . '</h1>';	
            $html .= '<p class="descripcion"> ' . $descripcion . '</p>';	
            $html .= '<p class="descripcion">' . $id_propietario . '</p>';
            $html .= '<div><button class="botonContactar" type="submit" class="boton-contactar" name="contactar">Contactar</button></div>';
            $i = $i + 1;
            
            $html .= '</div>';
        } 
        

		$html .= '</div>';

        return $html;
    }

}
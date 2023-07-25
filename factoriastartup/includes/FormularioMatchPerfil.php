<?php
namespace es\ucm\fdi\aw;

//$form = new FormularioMatchesSeleccionados(false);
//$htmlMostrarMatches = $form->gestiona();


class FormularioMatchPerfil extends Formulario
{
    
    private $id_match;
    private $listaMatches;

    public function __construct(&$datos) {
       parent::__construct('formAceptarMatch', ['urlRedireccion' => 'perfil.php']);
       //$this->listaMatches = $listaMatches;
       //$this->id_match = $id_match;
       //$this->listaMatches = $datos['listaMatches'];
       //$this->id_match = $datos['id_match'];

    }
    
    protected function generaCamposFormulario(&$datos)
    {
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
        <td> <a class="editBoton" href="procesarAceptarMatch.php?Matches={$id_match}">
        <img src="img/tick.jpg" width="25" height="20">
        </a><span>

        <td> <a class="editBoton" href="procesarEliminarMatch.php?Matches={$id_match}">
        <img src="img/x.png" width="25" height="20">
        </a><span>
        </div>
        

        EOF;


    return $html;
    }   

}
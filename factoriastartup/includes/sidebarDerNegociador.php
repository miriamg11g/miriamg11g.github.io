<?php

require_once __DIR__.'/config.php';

$tituloPagina = 'MatchesSeleccionados';

$MostrarFormulariosMatches = mostrarMatchesAceptados();

$rutaApp = RUTA_APP;

?>
    
    <aside id="sideBarDer">

        <h1 class="element titulo">MATCHES SELECCIONADOS</h1>       
        <br>
        <h3 class="element ListaTabla">Estos son todos los matches que has aceptado:</h3>   
        <div class="listaProyectos">
        
            <?php echo $MostrarFormulariosMatches; ?>
        </div>

    </aside>


<?php

function mostrarMatchesAceptados(){

$html = '';

$listaMatches = es\ucm\fdi\aw\Matches::obtenerTotalMatchesConfirmados();

$numfilas = sizeof($listaMatches);
$id = 0;
$i = 0;

$html = '<div class="box"> <div class="match" name="match" id="match">';

//$datos = '';

while ($numfilas > $i){

    $datos = array(
        "listaMatches" => $listaMatches,
        "id_match" => $i
    );

    $form = new es\ucm\fdi\aw\FormularioMatchesSeleccionados($datos);

    $htmlMostrarMatches = $form->gestiona2($datos);

    $html .= $htmlMostrarMatches;

    $i = $i + 1;

}

return $html;
}    

    



 
 

 